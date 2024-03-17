<?php

namespace App\Tests\Unit;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserTest extends TestCase
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

    /**
     * Test the setter and getter
     *
     * @return void
     */
    public function testGetSetUser(): void
    {
        $now = new \DateTimeImmutable();
        $date = $now->format('d-m-Y');


        $task = new Task();
        $task->setTitle('Tache test')
            ->setContent('Contenu tâche test')
            ->setIsDone(false)
            ->setCreatedAt(new \DateTimeImmutable());

        $user = $this->getEntityUser();
        
        $user->addTask($task);

        $this->assertNull($user->eraseCredentials());

        $this->assertEquals('password', $user->getPassword());

        $this->assertNull($user->getId());

        $this->assertEquals('jean.louis@todolist.fr', $user->getEmail());

        $this->assertEquals($date, $user->getCreatedAt()->format('d-m-Y'));

        $this->assertContains($task, $user->getTasks());

        $this->assertEquals("ROLE_USER", $user->getRoles()[0]);

        $user->setRoles(["ROLE_ADMIN"])
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->assertEquals("ROLE_ADMIN", $user->getRoles()[0]);

        $this->assertEquals($date, $user->getUpdatedAt()->format('d-m-Y'));
    }


    /**
     * Test the __toString method
     *
     * @return void
     */
    public function testUserToString(): void
    {
        $user = $this->getEntityUser();

        $userString = $user->__toString($user->getUsername());

        $this->assertSame($user->getUsername(), $userString);
    }
}
