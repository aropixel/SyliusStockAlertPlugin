<?php

declare(strict_types=1);

namespace Aropixel\SyliusStockAlertPlugin\Entity;

use Sylius\Component\Core\Model\Taxon as BaseTaxon;
use Sylius\Component\Taxonomy\Model\TaxonInterface;


class Taxon extends BaseTaxon implements TaxonInterface
{
    /** @var int */
    private $stockTresholdAlert;

    /**
     * @return int
     */
    public function getStockTresholdAlert(): ?int
    {
        return $this->stockTresholdAlert;
    }

    /**
     * @param int|null $stockTresholdAlert
     */
    public function setStockTresholdAlert(?int $stockTresholdAlert): void
    {
        $this->stockTresholdAlert = $stockTresholdAlert;
    }
}
