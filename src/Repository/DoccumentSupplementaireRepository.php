<?php

namespace App\Repository;

use App\Entity\DoccumentSupplementaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DoccumentSupplementaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoccumentSupplementaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoccumentSupplementaire[]    findAll()
 * @method DoccumentSupplementaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoccumentSupplementaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoccumentSupplementaire::class);
    }

    // /**
    //  * @return DoccumentSupplementaire[] Returns an array of DoccumentSupplementaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DoccumentSupplementaire
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
