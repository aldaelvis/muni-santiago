<?php

namespace App\Repository;

use App\Entity\Salida;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Salida|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salida|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salida[]    findAll()
 * @method Salida[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalidaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salida::class);
    }

    /**
     * @return Paginator Returns an array of Product objects
     */
    public function findAllDesc($page, $descripcion): Paginator
    {
        $qb = $this->createQueryBuilder('s')
            ->join('s.detalleSalidas', 'd')
            ->join('d.product', 'p')
            ->distinct()
            ->orderBy('s.id', 'DESC');

        if (null !== $descripcion) {
            $qb->where('s.name LIKE :descripcion')
                ->setParameter('descripcion', '%' . $descripcion . '%');
        }

        return (new Paginator($qb))->paginate($page);
    }

    /**
     * @return Paginator Returns an array of Product objects
     */
    public function findAllBetweenDesc($page, $date1, $date2): Paginator
    {
        $qb = $this->createQueryBuilder('s')
            ->join('s.detalleSalidas', 'd')
            ->join('d.product', 'p')
            ->where('s.date > :date1')
            ->andWhere('s.date <= :date2')
            ->orderBy('s.id', 'DESC')
            ->setParameter('date1', $date1)
            ->setParameter('date2', $date2);

        return (new Paginator($qb))->paginate($page);
    }

    /**
     * @return Salida[] Returns an array of DetalleSalida objects
     */
    public function findAllBetweenReporteDesc($date1, $date2, $date3)
    {
        $qb = $this->createQueryBuilder('s')
            ->join('s.detalleSalidas', 'd')
            ->join('d.product', 'p')
            ->join('p.medida', 'm')
            ->orderBy('s.id', 'DESC');

        if ($date1 !== null && $date2 !== null) {
            $qb->where('s.date > :date1')
                ->andWhere('s.date <= :date2')
                ->setParameter('date1', $date1)
                ->setParameter('date2', $date2);
        }
        if (null !== $date3) {
            $qb->andWhere('s.date LIKE :date3')
                ->setParameter('date3', '%' . $date3 . '%');
        }

        return $qb
            ->getQuery()
            ->getResult();
    }
}
