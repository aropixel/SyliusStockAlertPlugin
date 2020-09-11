<?php

declare(strict_types=1);

namespace Aropixel\SyliusStockAlertPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class AropixelSyliusStockAlertExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.xml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $this->loadBundlesTemplatesOverrides( $container );
    }

    /**
     * @param ContainerBuilder $container
     */
    private function loadBundlesTemplatesOverrides( ContainerBuilder $container ): void
    {
        $rootBundle = dirname( __FILE__, 2 );

        $container->loadFromExtension( 'twig', [
            'paths' => [
                $rootBundle . '/Resources/views/SyliusAdminBundle' => 'SyliusAdmin',
            ]
        ] );
    }
}
