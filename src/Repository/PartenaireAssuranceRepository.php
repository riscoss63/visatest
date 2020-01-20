<?php

namespace App\Repository;

use App\Entity\PartenaireAssurance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PartenaireAssurance|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartenaireAssurance|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartenaireAssurance[]    findAll()
 * @method PartenaireAssurance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartenaireAssuranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartenaireAssurance::class);
    }

    // /**
    //  * @return PartenaireAssurance[] Returns an array of PartenaireAssurance objects
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
    public function findOneBySomeField($value): ?PartenaireAssurance
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
