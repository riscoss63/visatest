<?php

namespace App\Repository;

use App\Entity\TarifTransport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TarifTransport|null find($id, $lockMode = null, $lockVersion = null)
 * @method TarifTransport|null findOneBy(array $criteria, array $orderBy = null)
 * @method TarifTransport[]    findAll()
 * @method TarifTransport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TarifTransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TarifTransport::class);
    }

    // /**
    //  * @return TarifTransport[] Returns an array of TarifTransport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TarifTransport
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
