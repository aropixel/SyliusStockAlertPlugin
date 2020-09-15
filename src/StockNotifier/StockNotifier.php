<?php


namespace Aropixel\SyliusStockAlertPlugin\StockNotifier;


use Aropixel\SyliusStockAlertPlugin\Entity\ProductVariant;
use Payum\Core\Model\Payment;
use Sylius\Component\Order\Model\Order;
use Sylius\Component\Order\Model\OrderItem;
use Sylius\Component\Payment\Model\PaymentInterface;

class StockNotifier
{
    const DEFAULT_STOCK_ALERT_TRESHOLD = 5;

    private $stockNotifiers;

    public function __construct(iterable $stockNotifiers)
    {
        $this->stockNotifiers = $stockNotifiers;
    }

    public function sendNotifications(PaymentInterface $payment)
    {
        foreach ($this->stockNotifiers as $stockNotifier) {

            /** @var OrderItem $item */
            foreach ($payment->getOrder()->getItems() as $item)
            {
                /** @var ProductVariant $variant */
                $variant = $item->getVariant();

                $stockAlertTreshold = $this->getStockAlertTreshold($variant);

                if (intval($variant->getOnHand()) <= $stockAlertTreshold) {
                    $stockNotifier->sendNotification($variant);
                }

            }
        }
    }


    /**
     * @param ProductVariant $variant
     * @return int
     */
    private function getStockAlertTreshold(ProductVariant $variant): int
    {

        $stockAlertTresholdProduct = $variant->getStockTresholdAlert();

        if (!empty($stockAlertTresholdProduct)) {
            return (int)$stockAlertTresholdProduct;
        }

        //TODO: récupérer tous les seuils d'alerte de tous les taxons et garder le plus restrictif
        $stockAlertTresholdTaxon = $variant->getProduct()->getMainTaxon()->getStockTresholdAlert();

        if (!empty($stockAlertTresholdTaxon)) {
            return (int)$stockAlertTresholdTaxon;
        }

        return self::DEFAULT_STOCK_ALERT_TRESHOLD;
    }

}
