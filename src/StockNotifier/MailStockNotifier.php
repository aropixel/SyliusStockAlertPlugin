<?php


namespace Aropixel\SyliusStockAlertPlugin\StockNotifier;


use Aropixel\SyliusStockAlertPlugin\Entity\ProductVariant;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MailStockNotifier implements StockNotifierInterface
{

    /** @var ParameterBagInterface */
    private $params;
    /**
     * @var SenderInterface
     */
    private $sender;

    public function __construct(ParameterBagInterface $params, SenderInterface $sender)
    {
        $this->params = $params;
        $this->sender = $sender;
    }

    public function sendNotification(ProductVariant $variant)
    {
        $emailRecipients = $this->params->get('aropixel.sylius_stock_alert.notifier_emails');

        $this->sender->send('alert_stock', $emailRecipients, [
                'productVariant' => $variant
            ]
        );

    }

}
