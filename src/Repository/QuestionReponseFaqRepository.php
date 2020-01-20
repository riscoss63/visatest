<?php

namespace App\Repository;

use App\Entity\QuestionReponseFaq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method QuestionReponseFaq|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionReponseFaq|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionReponseFaq[]    findAll()
 * @method QuestionReponseFaq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionReponseFaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionReponseFaq::class);
    }

    // /**
    //  * @return QuestionReponseFaq[] Returns an array of QuestionReponseFaq objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionReponseFaq
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
