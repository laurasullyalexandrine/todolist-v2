<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher,)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Administrateur
        $admin = new User();
        $admin->setUsername('laura')
            ->setEmail('laura@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->hasher->hashPassword(
                    $admin,
                    "password"
                )
            )
            ->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($admin);


        // Utilisateurs
        for ($u = 1; $u <= 500; $u++) {
            $user = new User();
            $user->setUsername($faker->userName())
                ->setEmail($user->getUsername() . $faker->safeEmailDomain())
                ->setRoles(['ROLE_USER'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setPassword(
                    $this->hasher->hashPassword(
                        $user,
                        "password"
                    )
                );

            // Les tâches
            for ($t= 1; $t <= 50; $t++) {
                $task = new Task();
                $task->setTitle('Tâche ' . $t)
                    ->setContent('Contenu pour les tâches ' . $t)
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
