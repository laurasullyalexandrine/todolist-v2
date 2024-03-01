<?php

namespace App\Tests\Unit;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TastValidateTest extends KernelTestCase
{

    /**
     * Return a Task Object
     *
     * @return Task
     */
    public function getEntityTask(): Task
    {
        return (new Task())
            ->setTitle('Titre de la tâche')
            ->setContent('Contenu de la tâche')
            ->setIsDone(false)
            ->setCreatedAt(new \DateTimeImmutable());
    }

    /**
     * Test validators
     *
     * @return void
     */
    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $task = $this->getEntityTask();

        $errors = $container->get('validator')->validate($task);

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

        $task = $this->getEntityTask();
        $task->setTitle('')
            ->setContent('');

        $errors = $container->get('validator')->validate($task);

        $this->assertCount(2, $errors);
    }
}
