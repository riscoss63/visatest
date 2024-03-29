<?php

namespace App\Repository;

use App\Entity\Voyageurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Voyageurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voyageurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voyageurs[]    findAll()
 * @method Voyageurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voyageurs::class);
    }

    // /**
    //  * @return Voyageurs[] Returns an array of Voyageurs objects
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
    public function findOneBySomeField($value): ?Voyageurs
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
