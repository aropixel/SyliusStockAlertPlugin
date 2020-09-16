<?php


namespace Aropixel\SyliusStockAlertPlugin\EventListener;

use Aropixel\SyliusStockAlertPlugin\Repository\ProductRepository;
use Aropixel\SyliusStockAlertPlugin\TresholdStockManager\TresholdStockManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class TaxonProductStockListener
{

    /**
     * @var TresholdStockManagerInterface
     */
    private $tresholdStockManager;
    /**
     * @var TaxonRepositoryInterface
     */
    private $taxonRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        TresholdStockManagerInterface $tresholdStockManager,
        TaxonRepositoryInterface $taxonRepository,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager
    ){
        $this->tresholdStockManager = $tresholdStockManager;
        $this->taxonRepository = $taxonRepository;
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    public function onTaxonUpdate(GenericEvent $event)
    {
        /** @var TaxonInterface $taxon */
        $taxon = $event->getSubject();

        if ($this->hasStockTresholdAlertChanged($taxon)) {

            $products = $this->productRepository->findProductsByTaxon($taxon->getId());

            foreach ($products as $product) {

                $productVariant = $product->getVariants()->first();

                if (empty($productVariant->getStockTresholdAlert())) {

                    if (!$this->tresholdStockManager->isStockCritical($productVariant)) {
                        $this->tresholdStockManager->removeProductVariantStockAlert($productVariant);
                    } else {
                        $this->tresholdStockManager->createProductVariantStockAlert($productVariant);
                    }

                }

            }
        }

    }

    /**
     * @param TaxonInterface $taxon
     * @return bool
     */
    private function hasStockTresholdAlertChanged(TaxonInterface $taxon): bool
    {
        $uow = $this->entityManager->getUnitOfWork();
        $uow->computeChangeSets();
        $taxonChangeSet = $uow->getEntityChangeSet($taxon);

        return array_key_exists('stockTresholdAlert', $taxonChangeSet);
    }

}
