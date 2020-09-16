<?php


namespace Aropixel\SyliusStockAlertPlugin\StockNotifier;

use Aropixel\SyliusStockAlertPlugin\Entity\ProductVariant;
use Aropixel\SyliusStockAlertPlugin\TresholdStockManager\TresholdStockManagerInterface;

class DashboardStockNotifier implements StockNotifierInterface
{

    /**
     * @var TresholdStockManagerInterface
     */
    private $tresholdStockManager;

    public function __construct(TresholdStockManagerInterface $tresholdStockManager)
    {
        $this->tresholdStockManager = $tresholdStockManager;
    }

    public function sendNotification(ProductVariant $variant)
    {
        $this->tresholdStockManager->createProductVariantStockAlert($variant);
    }

}
