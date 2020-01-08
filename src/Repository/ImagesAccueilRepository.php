<?php

namespace App\Repository;

use App\Entity\ImagesAccueil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ImagesAccueil|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagesAccueil|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagesAccueil[]    findAll()
 * @method ImagesAccueil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesAccueilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagesAccueil::class);
    }

    // /**
    //  * @return ImagesAccueil[] Returns an array of ImagesAccueil objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImagesAccueil
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
