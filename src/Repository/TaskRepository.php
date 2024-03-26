<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findByIsDoneFalse(User $user): array
    {
        return $this->createQueryBuilder('t')
            ->addSelect('u')
            ->leftJoin('t.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $user->getId())
            ->andWhere('t.isDone = :isDone')
            ->setParameter('isDone', false)
            ->orderBy('t.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByIsDoneTrue(User $user): array
    {
        return $this->createQueryBuilder('t')
            ->addSelect('u')
            ->leftJoin('t.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $user->getId())
            ->andWhere('t.isDone = :isDone')
            ->setParameter('isDone', true)
            ->orderBy('t.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
