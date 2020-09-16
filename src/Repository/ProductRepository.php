<?php


namespace Aropixel\SyliusStockAlertPlugin\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Product\Model\Product;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        string $productClass
    )
    {
        parent::__construct($registry, $productClass);
    }

    public function findProductsByTaxon($taxonId)
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->innerJoin('o.productTaxons', 'productTaxon')
            ->andWhere('productTaxon.taxon = :taxonId')
            ->setParameter('taxonId', $taxonId)
            ->getQuery()
        ;

        return $queryBuilder->getResult();
    }

}
