<?php

namespace App\Repository;

use App\Entity\DetalleSalida;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetalleSalida|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetalleSalida|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetalleSalida[]    findAll()
 * @method DetalleSalida[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetalleSalidaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetalleSalida::class);
    }

    // /**
    //  * @return DetalleSalida[] Returns an array of DetalleSalida objects
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
    public function findOneBySomeField($value): ?DetalleSalida
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
