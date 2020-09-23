<?php


namespace Aropixel\SyliusStockAlertPlugin\StockNotifier;

use Sylius\Component\Core\Model\ProductVariantInterface;

interface StockNotifierInterface
{
    public function sendNotification(ProductVariantInterface $variant);

}
