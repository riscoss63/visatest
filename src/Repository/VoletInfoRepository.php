<?php

namespace App\Repository;

use App\Entity\VoletInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VoletInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoletInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoletInfo[]    findAll()
 * @method VoletInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoletInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VoletInfo::class);
    }

    // /**
    //  * @return VoletInfo[] Returns an array of VoletInfo objects
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
    public function findOneBySomeField($value): ?VoletInfo
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
