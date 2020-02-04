<?php

namespace App\Repository;

use App\Entity\EvisaSend;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EvisaSend|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvisaSend|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvisaSend[]    findAll()
 * @method EvisaSend[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvisaSendRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvisaSend::class);
    }

    // /**
    //  * @return EvisaSend[] Returns an array of EvisaSend objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EvisaSend
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
