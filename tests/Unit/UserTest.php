<?php

namespace App\Tests\Unit;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    /**
     * Test the user role and created_at
     *
     * @return void
     */
    public function testUserRoleCreatedAt(): void
    {
        $now = new \DateTimeImmutable();
        $date = $now->format('d-m-Y');

        $task = new Task();
        $task->setTitle('Tache test')
            ->setContent('Contenu tâche test')
            ->setIsDone(false)
            ->setCreatedAt(new \DateTimeImmutable());

        $user = new User();
        $user->setUsername('Jean')
            ->setEmail('jean.louis@todolist.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword("password")
            ->setCreatedAt(new \DateTimeImmutable())
            ->addTask($task);

        $this->assertEquals($date, $user->getCreatedAt()->format('d-m-Y'));

        $this->assertContains($task, $user->getTasks());

        $this->assertEquals("ROLE_USER", $user->getRoles()[0]);

        $this->assertIsBool($user->removeTask($task)); // Faux
    }

    /**
     * Test the user role and updated_at
     *
     * @return void
     */
    public function testSetRoleUpdatedAt(): void
    {
        $now = new \DateTimeImmutable();
        $date = $now->format('d-m-Y');

        $user = new User();
        $user->setUsername('Jean')
            ->setEmail('jean.louis@todolist.fr')
            ->setRoles(["ROLE_USER"])
            ->setPassword("password")
            ->setCreatedAt(new \DateTimeImmutable());

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
    public function testTaskToString(): void
    {
        $user = new User();
        $user->setUsername('Jacques')
            ->setEmail('jacques.chirac@todolist.fr')
            ->setPassword("password");

        $userString = $user->__toString($user->getUsername());

        $this->assertSame($user->getUsername(), $userString);
    }
}
