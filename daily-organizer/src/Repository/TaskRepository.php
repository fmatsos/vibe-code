<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @return Task[]
     */
    public function findByStatus(User $user, string $status): array
    {
        return $this->findBy(['user' => $user, 'status' => $status]);
    }

    /**
     * @return Task[]
     */
    public function findByDueDate(User $user, \DateTimeInterface $date): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user = :user')
            ->andWhere('t.dueDate = :date')
            ->setParameter('user', $user)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Task[]
     */
    public function findAllByUser(User $user): array
    {
        return $this->findBy(['user' => $user]);
    }
}
