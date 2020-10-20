<?php

namespace App\Repository;

use App\Entity\Entry;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entry[]    findAll()
 * @method Entry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entry::class);
    }

    /**
     * @return Paginator Returns an array of Product objects
     */
    public function findAllDesc($page, $descripcion): Paginator
    {
        $qb = $this->createQueryBuilder('e')
            ->join('e.detailEntries', 'd')
            ->join('d.product', 'p')
            ->distinct()
            ->orderBy('e.id', 'DESC');

        if (null !== $descripcion) {
            $qb->where('e.name LIKE :descripcion')
                ->setParameter('descripcion', '%' . $descripcion . '%');
        }

        return (new Paginator($qb))->paginate($page);
    }

    /**
     * @return Paginator Returns an array of Product objects
     */
    public function findAllBetweenDesc($page, $date1, $date2): Paginator
    {
        $qb = $this->createQueryBuilder('e')
            ->join('e.detailEntries', 'd')
            ->join('d.product', 'p')
            ->where('e.date > :date1')
            ->andWhere('e.date <= :date2')
            ->orderBy('e.id', 'DESC')
            ->setParameter('date1', $date1)
            ->setParameter('date2', $date2);

        return (new Paginator($qb))->paginate($page);
    }

    /**
     * @return Entry[] Returns an array of Entry objects
     */
    public function findAllBetweenReporteDesc($date1, $date2, $date3)
    {
        $qb = $this->createQueryBuilder('e')
            ->join('e.detailEntries', 'd')
            ->join('d.product', 'p')
            ->orderBy('e.id', 'DESC');


        if ($date1 !== null && $date2 !== null) {
            $qb->where('e.date > :date1')
                ->andWhere('e.date <= :date2')
                ->setParameter('date1', $date1)
                ->setParameter('date2', $date2);
        }
        if (null !== $date3) {
            $qb->andWhere('e.date LIKE :date3')
                ->setParameter('date3', '%' . $date3 . '%');
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Entry[] Returns an array of Entry objects
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
    public function findOneBySomeField($value): ?Entry
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
