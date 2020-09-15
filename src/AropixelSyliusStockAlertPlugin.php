<?php

declare(strict_types=1);

namespace Aropixel\SyliusStockAlertPlugin;

use Aropixel\SyliusStockAlertPlugin\DependencyInjection\Compiler\StockNotifiersPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AropixelSyliusStockAlertPlugin extends Bundle
{
    use SyliusPluginTrait;
}
