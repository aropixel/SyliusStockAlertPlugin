<?php


namespace Aropixel\SyliusStockAlertPlugin\StockNotifier;


use Aropixel\SyliusStockAlertPlugin\Entity\ProductVariant;
use Aropixel\SyliusStockAlertPlugin\TresholdStockManager\TresholdStockManagerInterface;
use Sylius\Component\Order\Model\OrderItem;
use Sylius\Component\Payment\Model\PaymentInterface;

class StockNotifier
{
    private $stockNotifiers;
    /**
     * @var TresholdStockManagerInterface
     */
    private $tresholdStockManager;

    public function __construct(iterable $stockNotifiers, TresholdStockManagerInterface $tresholdStockManager)
    {
        $this->stockNotifiers = $stockNotifiers;
        $this->tresholdStockManager = $tresholdStockManager;
    }

    public function sendNotifications(PaymentInterface $payment)
    {
        foreach ($this->stockNotifiers as $stockNotifier) {

            /** @var OrderItem $item */
            foreach ($payment->getOrder()->getItems() as $item)
            {
                /** @var ProductVariant $variant */
                $variant = $item->getVariant();

                if ($this->tresholdStockManager->isStockCritical($variant)) {
                    $stockNotifier->sendNotification($variant);
                }

            }
        }
    }

}
