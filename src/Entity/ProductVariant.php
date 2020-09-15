<?php

namespace Aropixel\SyliusStockAlertPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;
use Sylius\Component\Product\Model\ProductVariantInterface;

class ProductVariant extends BaseProductVariant implements ProductVariantInterface
{
    /** @var int */
    private $stockTresholdAlert;


    /**
     * @var Collection|ProductVariantStockAlertInterface[]
     */
    protected $productVariantStockAlerts;


    public function __construct()
    {
        parent::__construct();

        $this->productVariantStockAlerts = new ArrayCollection();
    }

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

    /**
     * @return ProductVariantStockAlertInterface[]|Collection
     */
    public function getProductVariantStockAlerts()
    {
        return $this->productVariantStockAlerts;
    }

    /**
     * @param ProductVariantStockAlertInterface[]|Collection $productVariantStockAlerts
     */
    public function setProductVariantStockAlerts($productVariantStockAlerts): void
    {
        $this->productVariantStockAlerts = $productVariantStockAlerts;
    }



}
