<?php


namespace Aropixel\SyliusStockAlertPlugin\Twig;

use Aropixel\SyliusStockAlertPlugin\TresholdStockManager\TresholdStockManagerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StockTresholdExtension extends AbstractExtension
{

    /**
     * @var TresholdStockManagerInterface
     */
    private $tresholdStockManager;

    public function __construct(TresholdStockManagerInterface $tresholdStockManager)
    {
        $this->tresholdStockManager = $tresholdStockManager;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('stockTreshold', [$this, 'stockTreshold']),
        ];
    }

    public function stockTreshold(ProductVariantInterface $productVariant)
    {
        return $this->tresholdStockManager->getStockAlertTreshold($productVariant);
    }
}
