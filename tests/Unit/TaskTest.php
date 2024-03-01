<?php

namespace App\Tests\Unit;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{


    /**
     * Test the change in status of the task
     * Adding creation date and changing update date
     * 
     * @return void
     */
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


    /**
     * Test if the task is done
     *
     * @return void
     */
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

    /**
     * Test if the task has a user
     *
     * @return void
     */
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

    /**
     * Test if the task has a title
     *
     * @return void
     */
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

    /**
     * Test if the task has a content
     *
     * @return void
     */
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

        $task = new Task();
        $task->setTitle('Tâche test')
            ->setContent('Contenu tâche test')
            ->setIsDone(true)
            ->setUser($user);

        $tastkString = $task->__toString($task->getTitle());

        $this->assertSame($task->getTitle(), $tastkString);
    }
}
