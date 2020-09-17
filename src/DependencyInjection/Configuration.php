<?php


namespace Aropixel\SyliusStockAlertPlugin\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('aropixel_sylius_stock_alert');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('mail_stock_notifier')
                    ->children()
                        ->arrayNode('emails')
                            ->scalarPrototype()->end()
                    ->end()
                ->end() // mail_stock_notifier
            ->end();

        return $treeBuilder;
    }

}
