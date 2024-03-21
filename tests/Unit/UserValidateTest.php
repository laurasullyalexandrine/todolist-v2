<?php

namespace App\Tests\Unit;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserValidateTest extends KernelTestCase
{
    /**
     * Return a User object
     *
     * @return User
     */
    public function getEntityUser(): User
    {
        return (new User())
            ->setUsername('Jean')
            ->setEmail('jean.louis@todolist.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword("password")
            ->setCreatedAt(new \DateTimeImmutable());
    }

    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntityUser();

        $errors = $container->get('validator')->validate($user);

        $this->assertCount(0, $errors);
    }

        /**
     * Test validators
     *
     * @return void
     */
    public function testInvalid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $task = $this->getEntityUser();
        $task->setUsername('Naïm')
            ->setEmail('')
            ->setRoles(['ROLE_USER'])
            ->setPassword('');

        $errors = $container->get('validator')->validate($task);

        $this->assertCount(2, $errors);
    }
}
