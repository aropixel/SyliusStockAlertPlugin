<?php


namespace Aropixel\SyliusStockAlertPlugin\StockNotifier;

use Aropixel\SyliusStockAlertPlugin\Entity\ProductVariant;

interface StockNotifierInterface
{
    public function sendNotification(ProductVariant $variant);

}
