<?php

namespace App\Repository;

use App\Entity\VisaClassic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VisaClassic|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisaClassic|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisaClassic[]    findAll()
 * @method VisaClassic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisaClassicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisaClassic::class);
    }

    // /**
    //  * @return VisaClassic[] Returns an array of VisaClassic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VisaClassic
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
