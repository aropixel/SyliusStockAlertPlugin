<?php

namespace Aropixel\SyliusStockAlertPlugin\Entity;

use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;
use Sylius\Component\Product\Model\ProductVariantInterface;

class ProductVariant extends BaseProductVariant implements ProductVariantInterface
{
    /** @var int */
    private $stockTresholdAlert;

    /**
     * @return int
     */
    public function getStockTresholdAlert(): ?int
    {
        return $this->stockTresholdAlert;
    }

    /**
     * @param int $stockTresholdAlert
     */
    public function setStockTresholdAlert(int $stockTresholdAlert): void
    {
        $this->stockTresholdAlert = $stockTresholdAlert;
    }

}
