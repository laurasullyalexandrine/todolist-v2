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

        for ($t = 1; $t <= 15; $t++) {
            $taskAdmin = new Task();
            $taskAdmin->setTitle('Tâche administration ' . $t)
                ->setContent('Contenu pour les tâches d\'administration ' . $t)
                ->setIsDone(false)
                ->setCreatedAt(new \DateTimeImmutable());

            $admin->addTask($taskAdmin);

            $manager->persist($taskAdmin);
        }

        $manager->persist($admin);

        // Anonymous
        $anonymous = new User();
        $anonymous->setUsername('anonymous')
            ->setEmail('anonymous@todolist.fr')
            ->setRoles(['ROLE_ANONYMUS'])
            ->setPassword(
                $this->hasher->hashPassword(
                    $anonymous,
                    "anonymous"
                )
            )
            ->setCreatedAt(new \DateTimeImmutable());

        for ($t = 1; $t <= 15; $t++) {
            $taskAnonymous = new Task();
            $taskAnonymous->setTitle('Tâche anonyme ' . $t)
                ->setContent('Contenu pour les tâches anonymes ' . $t)
                ->setIsDone(false)
                ->setCreatedAt(new \DateTimeImmutable());

            $anonymous->addTask($taskAnonymous);

            $manager->persist($taskAnonymous);
        }

        $manager->persist($anonymous);


        // Users
        for ($u = 1; $u <= 200; $u++) {
            $user = new User();
            $user->setUsername($faker->userName())
                ->setEmail($user->getUsername() . '@todolist.fr')
                ->setRoles(['ROLE_USER'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setPassword(
                    $this->hasher->hashPassword(
                        $user,
                        "password"
                    )
                );

            // Tasks
            for ($t = 1; $t <= 15; $t++) {
                $task = new Task();
                $task->setTitle('Tâche utilisateur' . $t)
                    ->setContent('Contenu pour les tâches des utilisateurs' . $t)
                    ->setIsDone(false)
                    ->setCreatedAt(new \DateTimeImmutable());

                $user->addTask($task);

                $manager->persist($task);
            }

            $manager->persist($user);
        }
        $manager->flush();
    }
}
