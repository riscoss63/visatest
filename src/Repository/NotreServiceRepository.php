<?php

namespace App\Repository;

use App\Entity\NotreService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NotreService|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotreService|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotreService[]    findAll()
 * @method NotreService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotreServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotreService::class);
    }

    // /**
    //  * @return NotreService[] Returns an array of NotreService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NotreService
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
