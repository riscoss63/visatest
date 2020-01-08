<?php

namespace App\Repository;

use App\Entity\CategorieVisa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategorieVisa|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieVisa|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieVisa[]    findAll()
 * @method CategorieVisa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieVisaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieVisa::class);
    }

    // /**
    //  * @return CategorieVisa[] Returns an array of CategorieVisa objects
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
    public function findOneBySomeField($value): ?CategorieVisa
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
