<?php

namespace App\Repository;

use App\Entity\DoccumentObligatoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DoccumentObligatoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoccumentObligatoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoccumentObligatoire[]    findAll()
 * @method DoccumentObligatoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoccumentObligatoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoccumentObligatoire::class);
    }

    // /**
    //  * @return DoccumentObligatoire[] Returns an array of DoccumentObligatoire objects
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
    public function findOneBySomeField($value): ?DoccumentObligatoire
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
