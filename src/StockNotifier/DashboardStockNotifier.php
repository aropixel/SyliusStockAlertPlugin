<?php


namespace Aropixel\SyliusStockAlertPlugin\StockNotifier;


use Aropixel\SyliusStockAlertPlugin\Entity\ProductVariant;
use Aropixel\SyliusStockAlertPlugin\Entity\ProductVariantStockAlert;
use Aropixel\SyliusStockAlertPlugin\Repository\ProductVariantStockAlertRepository;
use Doctrine\ORM\EntityManagerInterface;

class DashboardStockNotifier implements StockNotifierInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ProductVariantStockAlertRepository
     */
    private $productVariantStockAlertRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductVariantStockAlertRepository $productVariantStockAlertRepository
    ) {
        $this->entityManager = $entityManager;
        $this->productVariantStockAlertRepository = $productVariantStockAlertRepository;
    }

    public function sendNotification(ProductVariant $variant)
    {
        $productVariantStockAlert = $this->productVariantStockAlertRepository->findBy(['productVariant' => $variant]);

        if (empty($productVariantStockAlert)) {
            $productVariantStockAlert = new ProductVariantStockAlert();
            $productVariantStockAlert->setProductVariant($variant);

            $this->entityManager->persist($productVariantStockAlert);
            $this->entityManager->flush();
        }
    }

}
