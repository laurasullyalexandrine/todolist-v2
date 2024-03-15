<?php

namespace App\Tests\Functional;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
    public function testAuthPageIsRestricted(): void
    {
        $this->client->request(Request::METHOD_GET, '/tasks');

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->client->followRedirect();

        $response = $this->client->getResponse();
        $redirectUrl = $this->client->getResponse()->headers->get('Location');

        $this->assertResponseStatusCodeSame($response->getStatusCode(404));

        $this->assertEquals("/", $redirectUrl);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testGetTaskListByUserSuccessful(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router');

        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_list'));

        $this->assertResponseIsSuccessful();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

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

    /**
     * Test the task not found
     *
     * @return void
     */
    public function testTaskNotFound(): void
    {
        $currentUser = $this->getUserTest();

        $urlGenerator = $this->client->getContainer()->get('router.default');

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_edit', ['id' => 33]));

        $task = $taskRepository->findOneBy(['user' => $currentUser, 'id' => 33]);

        $this->assertNull($task);

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * Test route edit user not connected
     *
     * @return void
     */
    public function testEditTaskUserNotLogged(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_edit', ['id' => 5946]));

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('.alert.alert-danger');
    }


    /**
     * Test updating task
     *
     * @return void
     */
    public function testEditTaskSuccessful(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);

        $task = $taskRepository->findOneBy(['user' => $currentUser]);
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_edit', ['id' => $task->getId()]));

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
        $this->client->loginUser($currentUser);
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);

        $task = $taskRepository->findOneBy(['user' => $currentUser]);

        $this->client->request(Request::METHOD_POST, $urlGenerator->generate('task_delete', ['id' => $task->getId()]));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! Votre tâche ' . '"' . $task->getTitle() . '"' . ' a été supprimée.');

        $this->assertRouteSame('task_list');
    }

    /**
     * Test the change in task status
     *
     * @return void
     */
    public function testToggleActionSuccessful()
    {
        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $urlGenerator = $this->client->getContainer()->get('router.default');

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);

        $task = $taskRepository->findOneBy(['user' => $currentUser]);
        $task->toggle(!$task->isIsDone());


        $this->client->request(Request::METHOD_POST, $urlGenerator->generate('task_toggle', ['id' => $task->getId()]));

        $task = $taskRepository->find($task->getId());
        $this->assertFalse($task->isIsDone());
    }
}
