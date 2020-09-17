<?php


namespace Aropixel\SyliusStockAlertPlugin\EventListener;

use Aropixel\SyliusStockAlertPlugin\TresholdStockManager\TresholdStockManagerInterface;
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
        $product = $event->getSubject();

        $this->tresholdStockManager->setStockAlertTresholdForProduct($product);
    }

}
