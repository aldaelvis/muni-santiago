<?php

namespace App\Repository;

use App\Entity\Product;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Paginator Returns an array of Product objects
     */
    public function findAllDesc($page = 1): Paginator
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC');

        return (new Paginator($qb))->paginate($page);
    }


    public function findProducts($value)
    {
        $em = $this->getEntityManager();
        $dq = $em->createQuery(
            'SELECT p FROM App\Entity\Product p WHERE p.description LIKE :product'
        );
        $dq->setParameter('product', '%' . $value . '%');

        return $dq->getResult();
    }

    /**
     * @return Paginator Returns an array of Product objects
     */
    public function findDescriptionDesc($page, $description): Paginator
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.description LIKE :description')
            ->orderBy('p.id', 'DESC')
            ->setParameter('description', '%' . $description . '%');

        return (new Paginator($qb))->paginate($page);
    }

}
