<?php

namespace App\Repository;

use App\Entity\CategorieFaq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategorieFaq|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieFaq|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieFaq[]    findAll()
 * @method CategorieFaq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieFaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieFaq::class);
    }

    // /**
    //  * @return CategorieFaq[] Returns an array of CategorieFaq objects
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
    public function findOneBySomeField($value): ?CategorieFaq
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
