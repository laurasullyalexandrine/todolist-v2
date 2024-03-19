<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
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
    public function getUserTest(): User
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $currentUser = $userRepository->findOneByUsername("laura");

        return $currentUser;
    }


    /**
     * Test the display of the login page
     *
     * @return void
     */
    public function testDisplayLogin()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('login'));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorTextContains('label', 'Nom d\'utilisateur :');

        $this->assertSelectorNotExists('.alert.alert-danger');
    }


    /**
     * Test for an authentication successful
     *
     * @return void
     */
    public function testLoginFormSuccessful(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request(Request::METHOD_GET, $urlGenerator->generate('login'));

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'laura';
        $form['password'] = 'admin';
        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->client->followRedirect();

        $this->assertEquals('homepage', $this->client->getRequest()->attributes->get('_route'));
    }

    /**
     * Test the redirect for user authenticate
     *
     * @return void
     */
    public function testRedirectIfUserAuthenticated()
    {
        $currentUser = $this->getUserTest();
        $this->client->loginUser($currentUser);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('login'));

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();

        $this->assertRouteSame('homepage');
    }

    /**
     * Test for an authentication error
     *
     * @return void
     */
    public function testLoginFormFailed(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('login'));

        $this->assertResponseIsSuccessful();

        $this->client->submitForm(
            'Se connecter',
            [
                'username' => 'johndoe@todilist.fr',
                'password' => 'fakepassword',
            ],
            'POST',
        );

        $this->assertResponseRedirects('/');
        $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorExists('.alert.alert-danger');
    }

    /**
     * Test the disconnection
     *
     * @return void
     */
    public function testLogout(): void
    {
        $currentUser = $this->getUserTest();

        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->loginUser($currentUser);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('logout'));

        $this->assertResponseRedirects('/');
    }
}
