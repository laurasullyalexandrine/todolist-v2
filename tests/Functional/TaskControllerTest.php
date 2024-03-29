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
        $currentUser = $userRepository->findOneByUsername("guy81");

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
     * Test road access to-do list with authorization
     *
     * @return void
     */
    public function testGetTaskListIsDoneFalseByUserSuccessful(): void
    {
        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_list'));

        $this->assertResponseIsSuccessful();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertRouteSame('task_list');
    }


    /**
     * Test the road to the tasks to be done
     *
     * @return void
     */
    public function testGetTaskListIsDoneTrueByUserSuccessful(): void
    {
        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_list_is_done'));

        $this->assertResponseIsSuccessful();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertRouteSame('task_list_is_done');
    }



    /**
     * Test the deadline of a task 
     *
     * @return void
     */
    public function testCreatedAtDeadlineUser(): void
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $currentUser = $userRepository->findOneByUsername("laura");
        $this->client->loginUser($currentUser);

        $manager = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        $now = new \DateTimeImmutable();
        $deadline = $now->sub(new \DateInterval('P29D'));
        // dump($deadline, 124);
        $task = new Task();
        $task->setTitle('Tâche administration n° 1');
        $task->setContent('Contenu de la tâche d\'administration n° 1');
        $task->setIsDone(false);
        $task->setCreatedAt($deadline);
        $task->getUser($currentUser);

        $manager->persist($task);
        $manager->flush();
        // dd($task, 125);
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_list'));

        $taskTitle = $task->getTitle();
        $createdAt = $task->getCreatedAt();

        $this->assertSelectorTextContains('div.alert.alert-danger', 'Oops ! La tâche ' . $taskTitle . ' créée le ' . $createdAt->format('d-m-Y') . ' a plus d\'un mois! Merci de l\'a traitée ou de la supprimer.');

        $this->assertRouteSame('task_list');
    }

    // lors du debug des variables $deadline et $task la date 
    /**
     * Test the deadline of a task 
     *
     * @return void
     */
    public function testCreatedAtDeadlineAdmin(): void
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $currentUser = $userRepository->findOneByUsername("anonymous");
        $this->client->loginUser($currentUser);

        $manager = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        $now = new \DateTimeImmutable();
        $deadline = $now->sub(new \DateInterval('P29D'));
        $task = new Task();
        $task->setTitle('Tâche anonyme n° 1');
        $task->setContent('Contenu de la tâche anonyme n° 1');
        $task->setIsDone(false);
        $task->setCreatedAt($deadline);
        $task->getUser($currentUser);

        $manager->persist($task);
        $manager->flush();

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_list'));

        $taskTitle = $task->getTitle();
        $createdAt = $task->getCreatedAt();

        $this->assertSelectorTextContains('div.alert.alert-danger', 'Oops ! La tâche ' . $taskTitle . ' créée le ' . $createdAt->format('d-m-Y') . ' a plus d\'un mois! Merci de l\'a traitée ou de la supprimer.');

        $this->assertRouteSame('task_list');
    }


    /**
     * Test route access list of completed tasks
     *
     * @return void
     */
    public function testGetTaskListIsDoneTrueByNotLoggedIn(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router');

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_list_is_done'));

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-danger', 'Merci de vous connecter!');

        $this->assertRouteSame('login');
    }



    /**
     * Test creating a task
     *
     * @return void
     */
    public function testCreateTaskSuccessful()
    {
        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $urlGenerator = $this->client->getContainer()->get('router');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_create'));

        $this->assertResponseIsSuccessful();

        $task = new Task();
        $this->client->submitForm('Ajouter', [
            'task[title]' => $task->setTitle('Ma nouvelle tâche n° 1'),
            'task[content]' => $task->setContent('Contenu de ma nouvelle tâche n° 1'),
        ]);

        $this->assertNotEmpty($task->getTitle());
        $this->assertNotEmpty($task->getContent());
        $this->assertFalse($task->isIsDone());

        $currentUser->addTask($task);

        $this->assertContains($task, $currentUser->getTasks());

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertRouteSame('task_list');

        $this->assertSelectorTextContains('div.alert.alert-success', 'Votre tâche a bien été ajoutée.');
    }

    /**
     * Test access create a user task not connected
     *
     * @return void
     */
    public function testCreateTaskUserNotLoggedIn(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_create'));

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-danger', 'Merci de vous connecter!');

        $this->assertRouteSame('login');
    }


    /**
     * Test updating task
     *
     * @return void
     */
    public function testEditTaskSuccessful(): void
    {
        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['user' => $currentUser]);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_edit', ['id' => $task->getId()]));

        $this->assertResponseIsSuccessful();

        $this->client->submitForm('Modifier', [
            'task[title]' => $task->setTitle('Ma tâche modifiée n° 1'),
            'task[content]' => $task->setContent('Contenu de ma tâche modifiée n° 1'),
        ]);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! Votre tâche a bien été modifiée.');

        $this->assertRouteSame('task_list');
    }

    /**
     * Access denied test when editing a task
     *
     * @return void
     */
    public function testAccessDenyEditTaskByUser(): void
    {
        // User logged in
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $otherUser = $userRepository->findOneByUsername("alexandria56");
        $this->client->loginUser($otherUser);

        $currentUser = $this->getUserTest();
        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['user' => $currentUser]);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_edit', ['id' => $task->getId()]));

        $this->assertNotEquals($currentUser, $otherUser);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * Access denied test when editing a task
     *
     * @return void
     */
    public function testAccessDenyEditAnonymousTask(): void
    {
        // User logged in
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $admin = $userRepository->findOneByUsername("laura");
        $this->client->loginUser($admin);

        $anonymous = $userRepository->findOneByUsername("anonymous");

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['user' => $anonymous]);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_edit', ['id' => $task->getId()]));

        $this->assertResponseIsSuccessful();

        $this->client->submitForm('Modifier', [
            'task[title]' => $task->getTitle(),
            'task[content]' => $task->setContent('Contenu de la tâche anonyme n° 2'),
        ]);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertTrue(in_array('ROLE_ADMIN', $admin->getRoles()));

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! Votre tâche a bien été modifiée.');

        $this->assertRouteSame('task_list');
    }

    /**
     * Test access edit a user task not connected
     *
     * @return void
     */
    public function testEditTaskUserNotLoggedIn(): void
    {
        $currentUser = $this->getUserTest();

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['user' => $currentUser]);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_edit', ['id' => $task->getId()]));

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-danger', 'Merci de vous connecter!');

        $this->assertRouteSame('login');
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

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['user' => $currentUser]);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_delete', ['id' => $task->getId()]));

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! Votre tâche ' . '"' . $task->getTitle() . '"' . ' a été supprimée.');

        $this->assertRouteSame('task_list');
    }


    /**
     * Access denied test when deleting a task
     *
     * @return void
     */
    public function testAccessDenyDeleteTask(): void
    {
        // User logged in
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $otherUser = $userRepository->findOneByUsername("alexandria56");
        $this->client->loginUser($otherUser);

        $currentUser = $this->getUserTest();

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['user' => $currentUser]);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_delete', ['id' => $task->getId()]));

        $this->assertNotEquals($currentUser, $otherUser);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * Access denied test when deleting an anonymous task by an average user
     *
     * @return void
     */
    public function testAccessDenyDeleteAnonymousTask(): void
    {
        // User logged in
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $admin = $userRepository->findOneByUsername("laura");
        $this->client->loginUser($admin);

        $anonymous = $userRepository->findOneByUsername("anonymous");

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['user' => $anonymous]);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_delete', ['id' => $task->getId()]));

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertTrue(in_array('ROLE_ADMIN', $admin->getRoles()));

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! Votre tâche ' . '"' . $task->getTitle() . '"' . ' a été supprimée.');

        $this->assertRouteSame('task_list');
    }

    /**
     * Test access delete a user task not connected
     *
     * @return void
     */
    public function testDeleteTaskUserNotLoggedIn(): void
    {
        $currentUser = $this->getUserTest();

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['user' => $currentUser]);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_delete', ['id' => $task->getId()]));

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-danger', 'Merci de vous connecter!');

        $this->assertRouteSame('login');
    }


    /**
     * Test task status change to true
     *
     * @return void
     */
    public function testToggleActionToTrueSuccessful()
    {
        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['user' => $currentUser]);
        $task->toggle(!$task->isIsDone());

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_toggle', ['id' => $task->getId()]));

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->client->followRedirect();

        $this->assertRouteSame('task_list');

        $task = $taskRepository->find($task->getId());
        $this->assertFalse($task->isIsDone());
    }

    /**
     * Test task status change to false
     *
     * @return void
     */
    public function testToggleActiontoFalseSuccessful()
    {
        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['user' => $currentUser]);
        $task->toggle($task->isIsDone());

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_toggle', ['id' => $task->getId()]));

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->client->followRedirect();

        $task = $taskRepository->find($task->getId());
        $this->assertTrue($task->isIsDone());

        $this->assertRouteSame('task_list');
    }
}
