<?php

namespace App\Tests\Functional;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Get a user in database
     *
     * @return User
     */
    public function getUserTest(): User
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $currentUser = $userRepository->findOneByUsername("augustin31");

        return $currentUser;
    }

    /**
     * Test redirection if user not logged in
     *
     * @return void
     */
    public function testUserNotLoggetInTaskList(): void
    {
        $this->client->request('GET', '/tasks');

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $response = $this->client->getResponse();

        $redirectUrl = $this->client->getResponse()->headers->get('Location');

        $this->assertResponseStatusCodeSame($response->getStatusCode(404));
        $this->assertEquals('/', $redirectUrl);
    }

    public function testGetTaskListByUserSuccessful(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_create'));

        $this->testUserNotLoggetInTaskList();

        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_list'));

        $this->assertResponseIsSuccessful();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);

        $taskRepository->findAllTaskByUser($currentUser);

        $this->assertRouteSame('task_list');
    }

    /**
     * Test creating a task
     *
     * @return void
     */
    public function testCreateTaskSuccessful()
    {
        $urlGenerator = $this->client->getContainer()->get('router');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_create'));

        $this->testUserNotLoggetInTaskList();

        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $this->client->request(Request::METHOD_POST, $urlGenerator->generate('task_create'));

        $this->assertResponseIsSuccessful();

        $task = new Task();
        $this->client->submitForm('Ajouter', [
            'task[title]' => $task->setTitle('Titre de ma nouvelle tâche 1'),
            'task[content]' => $task->setContent('Contenu de ma nouvelle tâche 1'),
        ]);

        $this->assertNotEmpty($task->getTitle());
        $this->assertNotEmpty($task->getContent());
        $this->assertFalse($task->isIsDone());

        $currentUser->addTask($task);

        $this->assertContains($task, $currentUser->getTasks());

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertRouteSame('task_list');

        $this->assertSelectorTextContains('div.alert.alert-success', 'Votre tâche a bien été ajoutée.');
    }

    /**
     * Test error handling
     *
     * @return void
     */
    public function testCreateTaskFailed(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_create'));

        $this->testUserNotLoggetInTaskList();

        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $this->client->request(Request::METHOD_POST, $urlGenerator->generate('task_create'));

        try {
            $task = new Task();
            $this->client->submitForm('Ajouter', [
                'task[title]' => $task->setTitle(''),
                'task[content]' => $task->setContent('Contenu de ma nouvelle tâche 1'),
            ]);
            $this->assertNotEmpty($task->getTitle());
        } catch (\Exception $e) {
            // Voir comment tester le catch
            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
            $this->assertEquals($e->getMessage(), "Failed asserting that a string is not empty.");

            $this->assertSelectorTextContains('div.invalid-feedback.d-block', 'This value should not be blank.');

            $this->assertRouteSame('task_create');
        }
    }

    public function testTaskNoFound(): void
    {
        $currentUser = $this->getUserTest();

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $tasks = $taskRepository->findAllTaskByUser($currentUser);

        foreach ($tasks as $task) {
            $urlGenerator = $this->client->getContainer()->get('router.default');
            $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_edit', ['id' => 33]));

            $this->assertNotEquals(33, $task->getId());
        }
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame($response->getStatusCode(404));
    }

    /**
     * Test updating task
     *
     * @return void
     */
    public function testEditTaskSuccessful(): void
    {
        $currentUser = $this->getUserTest();

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $tasks = $taskRepository->findAllTaskByUser($currentUser);

        foreach ($tasks as $task) {
            $urlGenerator = $this->client->getContainer()->get('router.default');
            $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_edit', ['id' => $task->getId()]));
        }

        $this->testUserNotLoggetInTaskList();

        $this->client->loginUser($currentUser);

        $this->client->request(Request::METHOD_POST, $urlGenerator->generate('task_edit', ['id' => $task->getId()]));

        $this->assertResponseIsSuccessful();

        $this->client->submitForm('Modifier', [
            'task[title]' => $task->setTitle('Titre modifié de ma tâche 1'),
            'task[content]' => $task->setContent('Contenu modifié de ma tâche 1'),
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! Votre tâche a bien été modifiée.');

        $this->assertRouteSame('task_list');
    }

    /**
     * Test deleting a task
     *
     * @return void
     */
    public function testDeleteTaskSuccesful(): void
    {
        $currentUser = $this->getUserTest();

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $tasks = $taskRepository->findAllTaskByUser($currentUser);

        foreach ($tasks as $task) {
            $urlGenerator = $this->client->getContainer()->get('router.default');
            $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_delete', ['id' => $task->getId()]));
        }

        $this->client->loginUser($currentUser);

        $this->client->request(Request::METHOD_POST, $urlGenerator->generate('task_delete', ['id' => $task->getId()]));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! Votre tâche ' . '"' . $task->getTitle() . '"' . ' a été supprimée.');

        $this->assertRouteSame('task_list');
    }
}
