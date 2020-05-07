<?php

namespace App\Repository;

use App\Entity\Poet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Poet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Poet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Poet[]    findAll()
 * @method Poet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Poet::class);
    }

    // /**
    //  * @return Poet[] Returns an array of Poet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Poet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
