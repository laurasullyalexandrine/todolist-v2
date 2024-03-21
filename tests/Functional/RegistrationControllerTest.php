<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Get a current user
     *
     * @return User
     */
    public function getAdminTest(): User
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $currentUser = $userRepository->findOneByUsername("laura");

        return $currentUser;
    }

    /**
     * Test redirection if admin user not logged in
     *
     * @return void
     */
    public function testAuthPageIsRestricted(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('admin_users_register'));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->client->followRedirect();

        $this->assertRouteSame('login');
    }

    /**
     * Test connected admin route access
     *
     * @return void
     */
    public function testAuthUser(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router');

        $currentAdmin = $this->getAdminTest();
        $this->client->loginUser($currentAdmin);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('admin_users_register'));

        $this->assertResponseIsSuccessful();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Créer un utilisateur');
        $this->assertRouteSame('admin_users_register');
    }

    /**
     * Test creating a user account
     *
     * @return void
     */
    public function testCreateUser(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router');

        $currentAdmin = $this->getAdminTest();
        $this->client->loginUser($currentAdmin);

        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('admin_users_register'));

        $this->assertResponseIsSuccessful();

        $formData = [
            'registration_form[roles][0]' => 'ROLE_USER',
            'registration_form[username]' => 'naim',
            'registration_form[email]' => 'naim@todolist.fr',
            'registration_form[password][first]' => 'password',
            'registration_form[password][second]' => 'password',
        ];

        $crawler =  $this->client->request(Request::METHOD_POST, $urlGenerator->generate('admin_users_register'));

        $form = $crawler->selectButton('Ajouter')->form();

        $form['registration_form[roles][0]']->setValue(true);
        $form['registration_form[roles][1]']->setValue(false);
        $form['registration_form[username]']->setValue($formData['registration_form[username]']);
        $form['registration_form[email]']->setValue($formData['registration_form[email]']);
        $form['registration_form[password][first]']->setValue($formData['registration_form[password][first]']);
        $form['registration_form[password][second]']->setValue($formData['registration_form[password][second]']);

        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $updatedUser = $userRepository->findOneByUsername('arnaud972');

        $this->assertTrue(in_array('ROLE_USER', $updatedUser->getRoles()));

        $this->assertSelectorTextContains('div.alert.alert-success', 'Le compte de l\'utilisateur compte est maintenant créé.');

        $this->assertRouteSame('admin_users_list');
    }
}
