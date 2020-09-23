<?php


namespace Aropixel\SyliusStockAlertPlugin\StockNotifier;


use Aropixel\SyliusStockAlertPlugin\TresholdStockManager\TresholdStockManagerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
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
                /** @var ProductVariantInterface $variant */
                $productVariant = $item->getVariant();

                if ($this->tresholdStockManager->isStockCritical($productVariant)) {
                    $this->tresholdStockManager->createProductVariantStockAlert($productVariant);
                    $stockNotifier->sendNotification($productVariant);
                } else {
                    $this->tresholdStockManager->removeProductVariantStockAlert($productVariant);
                }

            }
        }
    }

}
