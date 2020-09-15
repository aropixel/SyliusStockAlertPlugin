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
}
