<?php

namespace App\Repository;

use App\Entity\DetailEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailEntry[]    findAll()
 * @method DetailEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailEntry::class);
    }

    // /**
    //  * @return DetailEntry[] Returns an array of DetailEntry objects
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
    public function findOneBySomeField($value): ?DetailEntry
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
