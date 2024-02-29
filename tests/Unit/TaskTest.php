<?php

namespace App\Tests\Unit;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TaskTest extends TestCase
{
    public function testSomething(UserPasswordHasherInterface $hasher): void
    {
        $user = new User();
        $user->setUsername('Jean')
            ->setEmail('jean.louis@todolist.fr')
            ->setPassword(
                $hasher->hashPassword(
                    $user,
                    'password'
                )
            );

        $task = new Task('Tache test', 'Contenu tâche test', "1", $user);
        $this->assertTrue(0);
    }
}
