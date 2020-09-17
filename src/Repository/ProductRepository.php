<?php


namespace Aropixel\SyliusStockAlertPlugin\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
            ->where('o.enabled = true')
            ->innerJoin('o.productTaxons', 'productTaxon')
            ->andWhere('productTaxon.taxon = :taxonId')
            ->setParameter('taxonId', $taxonId)
            ->getQuery()
        ;

        return $queryBuilder->getResult();
    }

}
