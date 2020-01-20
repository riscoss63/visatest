<?php

namespace App\Repository;

use App\Entity\FraisComplementaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FraisComplementaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method FraisComplementaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method FraisComplementaire[]    findAll()
 * @method FraisComplementaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisComplementaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FraisComplementaire::class);
    }

    // /**
    //  * @return FraisComplementaire[] Returns an array of FraisComplementaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FraisComplementaire
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
