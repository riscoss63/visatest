<?php

namespace App\Repository;

use App\Entity\ReceptionDossier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ReceptionDossier|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReceptionDossier|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReceptionDossier[]    findAll()
 * @method ReceptionDossier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReceptionDossierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReceptionDossier::class);
    }

    // /**
    //  * @return ReceptionDossier[] Returns an array of ReceptionDossier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReceptionDossier
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
