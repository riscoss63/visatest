<?php

namespace App\Repository;

use App\Entity\PageDivers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PageDivers|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageDivers|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageDivers[]    findAll()
 * @method PageDivers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageDiversRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageDivers::class);
    }

    // /**
    //  * @return PageDivers[] Returns an array of PageDivers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PageDivers
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
