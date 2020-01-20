<?php

namespace App\Repository;

use App\Entity\PageAssurance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PageAssurance|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageAssurance|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageAssurance[]    findAll()
 * @method PageAssurance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageAssuranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageAssurance::class);
    }

    // /**
    //  * @return PageAssurance[] Returns an array of PageAssurance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PageAssurance
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
