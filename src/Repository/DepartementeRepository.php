<?php

namespace App\Repository;

use App\Entity\Departemente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Departemente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departemente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departemente[]    findAll()
 * @method Departemente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departemente::class);
    }

    // /**
    //  * @return Departemente[] Returns an array of Departemente objects
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
    public function findOneBySomeField($value): ?Departemente
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
