<?php


namespace Aropixel\SyliusStockAlertPlugin\TresholdStockManager;


use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;

interface TresholdStockManagerInterface
{
    public function setStockAlertTresholdForProduct(ProductInterface $product): void;

    public function isStockCritical(ProductVariantInterface $productVariant): bool;

    public function createProductVariantStockAlert(ProductVariantInterface $productVariant): void;

    public function removeProductVariantStockAlert(ProductVariantInterface $productVariant): void;

    public function getStockAlertTreshold(ProductVariantInterface $productVariant): ?int;

}
