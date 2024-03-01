<?php

namespace App\Tests\Unit;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TastFormTest extends KernelTestCase
{
    public function testSomething(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $user = new User();
        $user->setUsername('Jacques')
            ->setEmail('jacques.chirac@todolist.fr')
            ->setPassword("password");

        $task = new Task();
        $task->setTitle('Titre de la tâche')
            ->setContent('Contenu de la tâche')
            ->setIsDone(false)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUser($user);

        $errors = $container->get('validator')->validate($task);

        $this->assertCount(0, $errors);

    }
}
