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
     * Get a current user
     *
     * @return User
     */
    public function getUserTest(): User
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $currentUser = $userRepository->findOneByUsername("Laura");

        return $currentUser;
    }

    /**
     * Test for an authentication successful
     *
     * @return void
     */
    public function testLoginFormSuccessful(): void
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('login'));

        $this->assertResponseIsSuccessful();
 
        $this->client->submitForm(
            'Se connecter',
            [
                'username' => $this->getUserTest()->getUserIdentifier(),
                'password' => $this->getUserTest()->getPassword(),
            ],
            'POST',
        );

        $this->assertResponseRedirects();
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
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
