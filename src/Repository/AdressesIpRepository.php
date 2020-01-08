<?php

namespace App\Repository;

use App\Entity\AdressesIp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AdressesIp|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdressesIp|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdressesIp[]    findAll()
 * @method AdressesIp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdressesIpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdressesIp::class);
    }

    // /**
    //  * @return AdressesIp[] Returns an array of AdressesIp objects
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
    public function findOneBySomeField($value): ?AdressesIp
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
