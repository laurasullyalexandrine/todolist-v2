<?php

namespace App\Tests\Unit;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testChangeTaskStatus(): void
    {
        $now = new \DateTimeImmutable();
        $date = $now->format('d-m-Y');

        $user = new User();
        $user->setUsername('Jean')
            ->setEmail('jean.louis@todolist.fr')
            ->setPassword("password");


        $task = new Task();
        $task->setTitle('Tache test')
            ->setContent('Contenu tâche test')
            ->setIsDone(false)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUser($user);

        $this->assertEquals($date, $task->getCreatedAt()->format('d-m-Y'));

        $this->assertFalse($task->isIsDone());

        $task->toggle(true);

        $task->setUpdatedAt(new \DateTimeImmutable());

        $this->assertTrue($task->isIsDone());
        $this->assertEquals($date, $task->getUpdatedAt()->format('d-m-Y'));
    }


    public function testIfTaskIsDone(): void
    {
        $user = new User();
        $user->setUsername('Pierre')
            ->setEmail('pierre.bachelet@todolist.fr')
            ->setPassword("password");


        $task = new Task();
        $task->setTitle('Tâche test')
            ->setContent('Contenu tâche test')
            ->setIsDone(true)
            ->setUser($user);

        $this->assertTrue($task->isIsDone());

        $this->assertEquals(true, $task->isIsDone());
    }

    public function testGetUserFromTask(): void
    {
        $user = new User();
        $user->setUsername('David')
            ->setEmail('david.charvet@todolist.fr')
            ->setPassword("password");


        $task = new Task();
        $task->setTitle('Tâche test')
            ->setContent('Contenu tâche test')
            ->setIsDone(true)
            ->setUser($user);

        $this->assertSame($user, $task->getUser());
    }

    public function testGetTitleTask(): void
    {
        $user = new User();
        $user->setUsername('François')
            ->setEmail('françois.valerie@todolist.fr')
            ->setPassword("password");

        $task = new Task();
        $task->setTitle('Tâche test')
            ->setContent('Contenu tâche test')
            ->setIsDone(true)
            ->setUser($user);

        $this->assertSame('Tâche test', $task->getTitle());
    }

    public function testGetContentTask(): void
    {
        $user = new User();
        $user->setUsername('Paul')
            ->setEmail('paul.valerie@todolist.fr')
            ->setPassword("password");

        $task = new Task();
        $task->setTitle('Tâche test')
            ->setContent('Contenu tâche test')
            ->setIsDone(true)
            ->setUser($user);

        $this->assertSame('Contenu tâche test', $task->getContent());
    }

    public function testTaskToString(): void
    {
        $user = new User();
        $user->setUsername('Jacques')
            ->setEmail('jacques.chirac@todolist.fr')
            ->setPassword("password");

        $task = new Task();
        $task->setTitle('Tâche test')
            ->setContent('Contenu tâche test')
            ->setIsDone(true)
            ->setUser($user);

        $tastkString = $task->__toString($task->getTitle());

        $this->assertSame($task->getTitle(), $tastkString);
    }
}
