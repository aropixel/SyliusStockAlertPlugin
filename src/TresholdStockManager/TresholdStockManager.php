<?php

namespace Aropixel\SyliusStockAlertPlugin\TresholdStockManager;

use Aropixel\SyliusStockAlertPlugin\Entity\ProductVariantStockAlert;
use Aropixel\SyliusStockAlertPlugin\Repository\ProductVariantStockAlertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;

class TresholdStockManager implements TresholdStockManagerInterface
{

    private const DEFAULT_STOCK_ALERT_TRESHOLD = 5;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ProductVariantStockAlertRepository
     */
    private $productVariantStockAlertRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductVariantStockAlertRepository $productVariantStockAlertRepository
    ) {
        $this->entityManager = $entityManager;
        $this->productVariantStockAlertRepository = $productVariantStockAlertRepository;
    }

    /**
     * @param ProductVariantInterface $productVariant
     * @return bool
     */
    public function isStockCritical(ProductVariantInterface $productVariant): bool
    {
        $stockAlertTreshold = $this->getStockAlertTreshold($productVariant);

        return (intval($productVariant->getOnHand()) <= $stockAlertTreshold);
    }

    /**
     * @param ProductVariantInterface $productVariant
     * @return int
     */
    public function getStockAlertTreshold(ProductVariantInterface $productVariant): int
    {

        $stockAlertTresholdProduct = $productVariant->getStockTresholdAlert();

        if (!empty($stockAlertTresholdProduct)) {
            return (int)$stockAlertTresholdProduct;
        }

        $stockAlertTresholdTaxon = $this->getStockAlertTresholdTaxon($productVariant);

        if (!empty($stockAlertTresholdTaxon)) {
            return (int)$stockAlertTresholdTaxon;
        }

        return self::DEFAULT_STOCK_ALERT_TRESHOLD;
    }

    /**
     * @param ProductVariantInterface $productVariant
     * @return int
     */
    public function getStockAlertTresholdTaxon(ProductVariantInterface $productVariant)
    {
        $stockAlertTresholdTaxons = [];

        foreach ($productVariant->getProduct()->getTaxons() as $productTaxon) {

            if (!empty($productTaxon->getStockTresholdAlert()) ) {
                $stockAlertTresholdTaxons[] = (int)$productTaxon->getStockTresholdAlert();
            }
        }

        return min($stockAlertTresholdTaxons);
    }

    /**
     * @param ProductVariantInterface $productVariant
     */
    public function createProductVariantStockAlert(ProductVariantInterface $productVariant): void
    {
        $productVariantStockAlert = $this->productVariantStockAlertRepository->findBy(['productVariant' => $productVariant]);

        if (empty($productVariantStockAlert)) {
            $productVariantStockAlert = new ProductVariantStockAlert();
            $productVariantStockAlert->setProductVariant($productVariant);

            $this->entityManager->persist($productVariantStockAlert);
            $this->entityManager->flush();
        }
    }

    public function removeProductVariantStockAlert(ProductVariantInterface $productVariant): void
    {
        $productVariantStockAlert = $this->productVariantStockAlertRepository->findOneBy(['productVariant' => $productVariant]);

        if (!empty($productVariantStockAlert)) {
            $this->entityManager->remove($productVariantStockAlert);
            $this->entityManager->flush();
        }
    }
}
