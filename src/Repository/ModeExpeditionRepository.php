<?php

namespace App\Repository;

use App\Entity\ModeExpedition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ModeExpedition|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModeExpedition|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModeExpedition[]    findAll()
 * @method ModeExpedition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeExpeditionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModeExpedition::class);
    }

    // /**
    //  * @return ModeExpedition[] Returns an array of ModeExpedition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModeExpedition
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
