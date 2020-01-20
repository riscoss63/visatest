<?php

namespace App\Repository;

use App\Entity\EtatDossier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EtatDossier|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatDossier|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatDossier[]    findAll()
 * @method EtatDossier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatDossierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatDossier::class);
    }

    // /**
    //  * @return EtatDossier[] Returns an array of EtatDossier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EtatDossier
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
