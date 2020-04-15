<?php

namespace App\Repository;

use Acme\PostCount\Model\PostCount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostCount|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostCount|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostCount[]    findAll()
 * @method PostCount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrinePostCountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostCount::class);
    }

    // /**
    //  * @return PostCount[] Returns an array of PostCount objects
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
    public function findOneBySomeField($value): ?PostCount
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
