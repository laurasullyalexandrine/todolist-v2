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

    public function getUserTest(): User
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $currentUser = $userRepository->findOneByUsername("Laura");

        return $currentUser;
    }

    public function testLoginPage(): void
    {
        $currentUser = $this->getUserTest();

        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->loginUser($currentUser);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('login'));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testLoginForm(): void
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $this->client->submitForm('Se connecter', [
            'username' => $this->getUserTest()->getUserIdentifier(),
            'password' => $this->getUserTest()->getPassword(),
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testLogout(): void
    {
        $currentUser = $this->getUserTest();

        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->loginUser($currentUser);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('logout'));

        $this->assertResponseRedirects('/');
    }
}
