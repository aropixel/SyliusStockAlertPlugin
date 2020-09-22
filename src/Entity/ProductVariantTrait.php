<?php

declare(strict_types=1);

namespace Aropixel\SyliusStockAlertPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

trait ProductVariantTrait
{

    /** @var int
     * @ORM\Column(type="integer", nullable=true)
     *
     */
    private $stockTresholdAlert;

    /**
     * @var Collection|ProductVariantStockAlertInterface[]
     *
     * @ORM\OneToMany(targetEntity="Aropixel\SyliusStockAlertPlugin\Entity\ProductVariantStockAlert", mappedBy="productVariant")
     */
    protected $productVariantStockAlerts;


    public function __construct()
    {
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
     * @param int|null $stockTresholdAlert
     */
    public function setStockTresholdAlert(?int $stockTresholdAlert): void
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
