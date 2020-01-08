<?php

namespace App\Repository;

use App\Entity\DoccumentFacultatif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DoccumentFacultatif|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoccumentFacultatif|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoccumentFacultatif[]    findAll()
 * @method DoccumentFacultatif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoccumentFacultatifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoccumentFacultatif::class);
    }

    // /**
    //  * @return DoccumentFacultatif[] Returns an array of DoccumentFacultatif objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DoccumentFacultatif
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
