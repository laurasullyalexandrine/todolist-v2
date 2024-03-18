<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Get a admin user in database
     *
     * @return User
     */
    public function getAdminTest(): User
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $currentAdmin = $userRepository->findOneByUsername("laura");

        return $currentAdmin;
    }

    /**
     * Test redirection if admin user not logged in
     *
     * @return void
     */
    public function testAuthPageIsRestricted(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('admin_users_list'));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->client->followRedirect();

        $this->assertRouteSame('login');
    }

    /**
     * Test access to the road by an admin
     *
     * @return void
     */
    public function testGetUsersListByAdminSuccessful(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router');

        $currentAdmin = $this->getAdminTest();
        $this->client->loginUser($currentAdmin);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('admin_users_list'));
        $this->assertResponseIsSuccessful();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertRouteSame('admin_users_list');

        $this->assertSelectorNotExists('div.alert.alert-warning', 'Il n\'y a pas encore d\'utilisateur enregistré.');
    }

    /**
     * Test updating user by an admin
     *
     * @return void
     */
    public function testEditUserSuccessful(): void
    {
        $currentAdmin = $this->getAdminTest();
        $this->client->loginUser($currentAdmin);

        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        $user = $userRepository->findOneByUsername(['user' => 'raymond72']);

        $urlGenerator = $this->client->getContainer()->get('router');

        $this->client->request(Request::METHOD_POST, $urlGenerator->generate('admin_users_edit', ['id' => $user->getId()]));
        $this->assertResponseIsSuccessful();

        $this->client->submitForm('Modifier', [
            'user[username]' => 'raymond72',
            'user[email]' => 'raymond72@todolist.fr',
            'user[password][first]' => 'password_2',
            'user[password][second]' => 'password_2',
        ]);

        $this->assertInstanceOf(User::class, $user);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! L\'utilisateur a bien été modifié.');

        $this->assertRouteSame('admin_users_list');
    }

    public function testCheckboxRoles(): void
    {
        $currentAdmin = $this->getAdminTest();
        $this->client->loginUser($currentAdmin);

        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        $user = $userRepository->findOneByUsername(['user' => 'raymond72']);

        $urlGenerator = $this->client->getContainer()->get('router');

        $crawler =  $this->client->request(Request::METHOD_GET, $urlGenerator->generate('admin_users_edit', ['id' => $user->getId()]));
        $this->assertResponseIsSuccessful();

        $formData = [
            'user[roles][1]' => 'ROLE_ADMIN',
            'user[username]' => 'raymond72',
            'user[email]' => 'raymond72@todolist.fr',
            'user[password][first]' => 'password_2',
            'user[password][second]' => 'password_2',
        ];
        $crawler =  $this->client->request(Request::METHOD_POST, $urlGenerator->generate('admin_users_edit', ['id' => $user->getId()]));

        $form = $crawler->selectButton('Modifier')->form();

        $form['user[roles][0]']->setValue(false);
        $form['user[roles][1]']->setValue(true);
        $form['user[username]']->setValue($formData['user[username]']);
        $form['user[email]']->setValue($formData['user[email]']);
        $form['user[password][first]']->setValue($formData['user[password][first]']);
        $form['user[password][second]']->setValue($formData['user[password][second]']);

        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $updatedUser = $userRepository->findOneByUsername('raymond72');

        $this->assertTrue(in_array('ROLE_ADMIN', $updatedUser->getRoles()));

        $this->assertSelectorTextContains('div.alert.alert-success', 'L\'utilisateur a bien été modifié.');
    }
}