<?php

namespace App\Repository;

use App\Entity\PostCount;
use App\Model\PostCountFinderInterface;
use App\Model\PostCountInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostCount|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostCount|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostCount[]    findAll()
 * @method PostCount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostCountRepository extends ServiceEntityRepository implements PostCountFinderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostCount::class);
    }

    public function findOneByPostDateOrCreate(\DateTimeInterface $postedDate): PostCountInterface
    {
        $targetCount = $this->findOneBy([
            'postDate' => $postedDate,
        ]);
        if (!$targetCount) {
            $targetCount = new PostCount();
            $targetCount
                ->setPostDate($postedDate)
                ->setPostCount(0)
            ;
        }

        return $targetCount;
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
