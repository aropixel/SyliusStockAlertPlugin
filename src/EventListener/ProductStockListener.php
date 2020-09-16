<?php


namespace Aropixel\SyliusStockAlertPlugin\EventListener;

use Aropixel\SyliusStockAlertPlugin\TresholdStockManager\TresholdStockManagerInterface;
use Sylius\Component\Product\Model\ProductInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class ProductStockListener
{

    /**
     * @var TresholdStockManagerInterface
     */
    private $tresholdStockManager;

    public function __construct(
        TresholdStockManagerInterface $tresholdStockManager
    ){
        $this->tresholdStockManager = $tresholdStockManager;
    }

    public function onProductUpdate(GenericEvent $event)
    {
        /** @var ProductInterface $product */
        $product = $event->getSubject();

        $productVariant = $product->getVariants()->first();

        if ($this->tresholdStockManager->isStockCritical($productVariant)) {
            $this->tresholdStockManager->createProductVariantStockAlert($productVariant);
        } else {
            $this->tresholdStockManager->removeProductVariantStockAlert($productVariant);
        }
    }

}
