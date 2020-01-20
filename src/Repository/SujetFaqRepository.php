<?php

namespace App\Repository;

use App\Entity\SujetFaq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SujetFaq|null find($id, $lockMode = null, $lockVersion = null)
 * @method SujetFaq|null findOneBy(array $criteria, array $orderBy = null)
 * @method SujetFaq[]    findAll()
 * @method SujetFaq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SujetFaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SujetFaq::class);
    }

    // /**
    //  * @return SujetFaq[] Returns an array of SujetFaq objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SujetFaq
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
