<?php


namespace Aropixel\SyliusStockAlertPlugin\StockNotifier;


use Sylius\Component\Core\Model\ProductVariantInterface;
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

    public function sendNotification(ProductVariantInterface $variant)
    {
        if ($this->params->get('aropixel.sylius_stock_alert.email_notifier.enabled')) {
            $emailRecipients = $this->params->get('aropixel.sylius_stock_alert.email_notifier.recipients');

            $this->sender->send('alert_stock', $emailRecipients, [
                    'productVariant' => $variant
                ]
            );
        }
    }

}
