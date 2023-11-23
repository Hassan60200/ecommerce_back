<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
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

    public function searchProduct($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title = :value')
            ->setParameter(':value', $value)
            ->getQuery()
            ->getResult();
    }

    public function searchByCategory($value)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.Category', 'c')
            ->andWhere('c.name = :value')
            ->setParameter(':value', $value)
            ->getQuery()
            ->getResult();
    }
}
