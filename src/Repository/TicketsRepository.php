<?php

namespace App\Repository;

use App\Entity\Tickets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tickets>
 */
class TicketsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tickets::class);
    }

       public function countTicketsByState(int $stateId): int
       {
           return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.state = :stateId')
            ->setParameter('stateId', $stateId)
            ->getQuery()
            ->getSingleScalarResult();
       }

    public function countTicketsByCategory(int $categoryId): int
       {
           return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.category = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->getSingleScalarResult();
       }
}
