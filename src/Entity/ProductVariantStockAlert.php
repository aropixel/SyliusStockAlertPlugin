<?php


namespace Aropixel\SyliusStockAlertPlugin\Entity;


use Sylius\Component\Product\Model\ProductVariantInterface;

class ProductVariantStockAlert implements ProductVariantStockAlertInterface
{

    /** @var int */
    private $id;

    /** @var ProductVariantInterface */
    private $productVariant;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ProductVariantInterface
     */
    public function getProductVariant(): ProductVariantInterface
    {
        return $this->productVariant;
    }

    /**
     * @param ProductVariantInterface $productVariant
     */
    public function setProductVariant(ProductVariantInterface $productVariant): void
    {
        $this->productVariant = $productVariant;
    }

}
