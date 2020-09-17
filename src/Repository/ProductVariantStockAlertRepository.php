<?php


namespace Aropixel\SyliusStockAlertPlugin\Repository;

use Aropixel\SyliusStockAlertPlugin\Entity\ProductVariantStockAlert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductVariantStockAlertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductVariantStockAlert::class);
    }


    public function findAllEnabled()
    {
        $queryBuilder = $this->createQueryBuilder('pvsa')
            ->innerJoin('pvsa.productVariant', 'productVariant')
            ->innerJoin('productVariant.product', 'product')
            ->where('product.enabled = true')
            ->getQuery()
        ;

        return $queryBuilder->getResult();
    }
}
