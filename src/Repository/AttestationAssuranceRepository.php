<?php

namespace App\Repository;

use App\Entity\AttestationAssurance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AttestationAssurance|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttestationAssurance|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttestationAssurance[]    findAll()
 * @method AttestationAssurance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttestationAssuranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttestationAssurance::class);
    }

    // /**
    //  * @return AttestationAssurance[] Returns an array of AttestationAssurance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttestationAssurance
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
