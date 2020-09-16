<?php


namespace Aropixel\SyliusStockAlertPlugin\EventListener;


use Aropixel\SyliusStockAlertPlugin\Repository\ProductVariantStockAlertRepository;
use Aropixel\SyliusStockAlertPlugin\StockNotifier\DashboardStockNotifier;
use Aropixel\SyliusStockAlertPlugin\TresholdStockManager\TresholdStockManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Product\Model\ProductInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class ProductStockListener
{

    /**
     * @var TresholdStockManagerInterface
     */
    private $tresholdStockManager;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ProductVariantStockAlertRepository
     */
    private $productVariantStockAlertRepository;
    /**
     * @var DashboardStockNotifier
     */
    private $dashboardStockNotifier;

    public function __construct(
        TresholdStockManagerInterface $tresholdStockManager,
        EntityManagerInterface $entityManager,
        ProductVariantStockAlertRepository $productVariantStockAlertRepository,
        DashboardStockNotifier $dashboardStockNotifier
    ){
        $this->tresholdStockManager = $tresholdStockManager;
        $this->entityManager = $entityManager;
        $this->productVariantStockAlertRepository = $productVariantStockAlertRepository;
        $this->dashboardStockNotifier = $dashboardStockNotifier;
    }

    public function onProductUpdate(GenericEvent $event)
    {
        /** @var ProductInterface $product */
        $product = $event->getSubject();

        $productVariant = $product->getVariants()->first();

        if (!$this->tresholdStockManager->isStockCritical($productVariant)) {
            $productVariantStockAlert = $this->productVariantStockAlertRepository->findOneBy(['productVariant' => $productVariant]);
            $this->entityManager->remove($productVariantStockAlert);
            $this->entityManager->flush();
            return;
        }

        $this->dashboardStockNotifier->sendNotification($productVariant);
    }

}
