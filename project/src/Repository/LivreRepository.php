<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

       /**
        * @return Livre[] Returns an array of Livre objects
        */
       public function findByUser($userId): array
       {
           return $this->createQueryBuilder('l')
               ->andWhere('l.user = :userId')
               ->setParameter('userId', $userId)
               ->orderBy('l.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Livre
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
