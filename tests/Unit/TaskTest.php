<?php

namespace App\Tests\Unit;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /**
     * Return a Task Object
     *
     * @return Task
     */
    public function getEntityTask(): Task
    {
        $user = new User();
        $user->setUsername('Pierre')
            ->setEmail('pierre.bachelet@todolist.fr')
            ->setPassword("password");

        $task = new Task();
        $task->setTitle('Titre de la tâche')
            ->setContent('Contenu de la tâche')
            ->setIsDone(false)
            ->setCreatedAt(new \DateTimeImmutable());

        $user->addTask($task);
        return $task;
    }

    /**
     * Test the change in status of the task
     * Adding creation date and changing update date
     * 
     * @return void
     */
    public function testToggle(): void
    {
        $now = new \DateTimeImmutable();
        $date = $now->format('d-m-Y');

        $task = $this->getEntityTask();

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
    public function testGetTask(): void
    {
        $task = $this->getEntityTask();
        $task->setIsDone(true);

        $this->assertNull($task->getId());
        $this->assertTrue($task->isIsDone());

        $this->assertSame('Titre de la tâche', $task->getTitle());
        $this->assertSame('Contenu de la tâche', $task->getContent());
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

    public function testRemoveTask(): void
    {
        $task = $this->getEntityTask();
        $user = $task->getUser();

        $user->removeTask($task);

        $this->assertFalse($user->getTasks()->contains($task));

        $this->assertNull($task->getUser());
    }

    /**
     * Test the __toString method
     *
     * @return void
     */
    public function testTaskToString(): void
    {
        $task = $this->getEntityTask();

        $taskString = $task->__toString();

        $this->assertSame($task->getTitle(), $taskString);
    }
}
