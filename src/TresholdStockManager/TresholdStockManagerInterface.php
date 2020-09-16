<?php


namespace Aropixel\SyliusStockAlertPlugin\TresholdStockManager;


use Sylius\Component\Product\Model\ProductVariantInterface;

interface TresholdStockManagerInterface
{
    public function isStockCritical(ProductVariantInterface $productVariant): bool;

    public function createProductVariantStockAlert(ProductVariantInterface $productVariant): void;

    public function removeProductVariantStockAlert(ProductVariantInterface $productVariant): void;

    public function getStockAlertTreshold(ProductVariantInterface $productVariant): int;

}
