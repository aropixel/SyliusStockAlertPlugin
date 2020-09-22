<?php

declare(strict_types=1);

namespace Aropixel\SyliusStockAlertPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;


trait TaxonTrait
{
    /** @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
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
