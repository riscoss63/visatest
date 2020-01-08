<?php

namespace App\Repository;

use App\Entity\EVisa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EVisa|null find($id, $lockMode = null, $lockVersion = null)
 * @method EVisa|null findOneBy(array $criteria, array $orderBy = null)
 * @method EVisa[]    findAll()
 * @method EVisa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EVisaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EVisa::class);
    }

    // /**
    //  * @return EVisa[] Returns an array of EVisa objects
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
    public function findOneBySomeField($value): ?EVisa
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
