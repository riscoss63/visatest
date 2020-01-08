<?php

namespace App\Repository;

use App\Entity\DoccumentOfficiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DoccumentOfficiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoccumentOfficiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoccumentOfficiel[]    findAll()
 * @method DoccumentOfficiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoccumentOfficielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoccumentOfficiel::class);
    }

    // /**
    //  * @return DoccumentOfficiel[] Returns an array of DoccumentOfficiel objects
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
    public function findOneBySomeField($value): ?DoccumentOfficiel
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
