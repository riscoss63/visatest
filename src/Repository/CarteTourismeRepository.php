<?php

namespace App\Repository;

use App\Entity\CarteTourisme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CarteTourisme|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarteTourisme|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarteTourisme[]    findAll()
 * @method CarteTourisme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteTourismeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarteTourisme::class);
    }

    // /**
    //  * @return CarteTourisme[] Returns an array of CarteTourisme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CarteTourisme
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
