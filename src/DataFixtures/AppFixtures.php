<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @codeCoverageIgnore
 */
class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // tasks lasting more than a month
        $now = new \DateTimeImmutable();
        $oneMonthAgo = $now->sub(new \DateInterval('P1M'));

        // Administrator
        $admin = new User();
        $admin->setUsername('laura')
            ->setEmail('laura@todolist.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->hasher->hashPassword(
                    $admin,
                    "admin"
                )
            )
            ->setCreatedAt(new \DateTimeImmutable());

        // current task one month ago
        $taskAdminOneMonthAgo = new Task();
        $taskAdminOneMonthAgo->setTitle('Tâche administration n° 1')
            ->setContent('Contenu de la tâche d\'administration n° 1')
            ->setIsDone(false)
            ->setCreatedAt($oneMonthAgo);

        $admin->addTask($taskAdminOneMonthAgo);

        $manager->persist($taskAdminOneMonthAgo);

        // current tasks
        for ($t = 2; $t <= 5; $t++) {
            $taskAdmin = new Task();
            $taskAdmin->setTitle('Tâche administration n° ' . $t)
                ->setContent('Contenu de la tâche d\'administration n° ' . $t)
                ->setIsDone(false)
                ->setCreatedAt(new \DateTimeImmutable());

            $admin->addTask($taskAdmin);

            $manager->persist($taskAdmin);
        }

        // tasks is done
        for ($t = 1; $t <= 4; $t++) {
            $taskAdmin = new Task();
            $taskAdmin->setTitle('Tâche administration terminée n° ' . $t)
                ->setContent('Contenu de la tâche d\'administration terminée n° ' . $t)
                ->setIsDone(true)
                ->setCreatedAt(new \DateTimeImmutable());

            $admin->addTask($taskAdmin);

            $manager->persist($taskAdmin);
        }

        $manager->persist($admin);

        // Anonymous
        $anonymous = new User();
        $anonymous->setUsername('anonymous')
            ->setEmail('anonymous@todolist.fr')
            ->setRoles(['ROLE_ANONYMOUS'])
            ->setPassword(
                $this->hasher->hashPassword(
                    $anonymous,
                    "anonymous"
                )
            )
            ->setCreatedAt(new \DateTimeImmutable());


        // current task one month ago
        $taskAdminOneMonthAgo = new Task();
        $taskAdminOneMonthAgo->setTitle('Tâche anonyme n° 1')
            ->setContent('Contenu de la tâche anonyme n° 1')
            ->setIsDone(false)
            ->setCreatedAt($oneMonthAgo);

        $anonymous->addTask($taskAdminOneMonthAgo);

        $manager->persist($taskAdminOneMonthAgo);

        // current tasks
        for ($t = 2; $t <= 8; $t++) {
            $taskAnonymous = new Task();
            $taskAnonymous->setTitle('Tâche anonyme n° ' . $t)
                ->setContent('Contenu de la tâche anonyme n° ' . $t)
                ->setIsDone(false)
                ->setCreatedAt(new \DateTimeImmutable());

            $anonymous->addTask($taskAnonymous);

            $manager->persist($taskAnonymous);
        }

        // tasks is done
        for ($t = 1; $t <= 6; $t++) {
            $taskAnonymous = new Task();
            $taskAnonymous->setTitle('Tâche anonyme terminée n° ' . $t)
                ->setContent('Contenu de la tâche anonyme terminée n° ' . $t)
                ->setIsDone(true)
                ->setCreatedAt(new \DateTimeImmutable());

            $anonymous->addTask($taskAnonymous);

            $manager->persist($taskAnonymous);
        }

        $manager->persist($anonymous);


        // User Paul
        $paul = new User();
        $paul->setUsername('paul')
            ->setEmail('paul@todolist.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword(
                $this->hasher->hashPassword(
                    $paul,
                    "password"
                )
            )
            ->setCreatedAt(new \DateTimeImmutable());

        // current tasks one month ago
        for ($t = 1; $t <= 2; $t++) {
            $taskPaul = new Task();
            $taskPaul->setTitle('Tâche à faire n° ' . $t)
                ->setContent('Contenu de la tâche à faire n° ' . $t)
                ->setIsDone(false)
                ->setCreatedAt($oneMonthAgo);

            $paul->addTask($taskPaul);

            $manager->persist($taskPaul);
        }

        $manager->persist($paul);

        // User Pauline
        $pauline = new User();
        $pauline->setUsername('pauline')
            ->setEmail('pauline@todolist.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword(
                $this->hasher->hashPassword(
                    $pauline,
                    "password"
                )
            )
            ->setCreatedAt(new \DateTimeImmutable());

        // current tasks
        for ($t = 1; $t <= 8; $t++) {
            $taskPauline = new Task();
            $taskPauline->setTitle('Tâche à faire n° ' . $t)
                ->setContent('Contenu de la tâche à faire n° ' . $t)
                ->setIsDone(false)
                ->setCreatedAt(new \DateTimeImmutable());

            $pauline->addTask($taskPauline);

            $manager->persist($taskPauline);
        }

        // tasks is done
        for ($t = 1; $t <= 6; $t++) {
            $taskPauline = new Task();
            $taskPauline->setTitle('Tâche terminée n° ' . $t)
                ->setContent('Contenu de la tâche terminée n° ' . $t)
                ->setIsDone(true)
                ->setCreatedAt(new \DateTimeImmutable());

            $pauline->addTask($taskPauline);

            $manager->persist($taskPauline);
        }

        $manager->persist($pauline);

        // Users
        for ($u = 1; $u <= 18; $u++) {
            $user = new User();
            $user->setUsername($faker->firstName().$u)
                ->setEmail(strtolower($user->getUsername()) . '@todolist.fr')
                ->setRoles(['ROLE_USER'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setPassword(
                    $this->hasher->hashPassword(
                        $user,
                        "password"
                    )
                );

            // current tasks
            for ($t = 1; $t <= 10; $t++) {
                $task = new Task();
                $task->setTitle('Tâche n° ' . $t . ' de ' . $user->getUsername())
                    ->setContent('Contenu de la tâche n° ' . $t . ' de ' . $user->getUsername())
                    ->setIsDone(false)
                    ->setCreatedAt(new \DateTimeImmutable());

                $user->addTask($task);

                $manager->persist($task);
            }

            // tasks is done
            for ($t = 1; $t <= 12; $t++) {
                $task = new Task();
                $task->setTitle('Tâche terminée n° ' . $t . ' de ' . $user->getUsername())
                    ->setContent('Contenu de la tâche terminée n° ' . $t . ' de ' . $user->getUsername())
                    ->setIsDone(true)
                    ->setCreatedAt(new \DateTimeImmutable());

                $user->addTask($task);

                $manager->persist($task);
            }

            $manager->persist($user);
        }
        $manager->flush();
    }
}
