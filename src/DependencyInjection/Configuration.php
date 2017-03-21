<?php

namespace Acme\SyliusCatalogPromotionPlugin\DependencyInjection;

use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotion;
use Acme\SyliusCatalogPromotionPlugin\Form\Type\CatalogPromotionType;
use Acme\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepository;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Form\Type\DefaultResourceType;
use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sylius_catalog_promotion');

        $this->addCatalogPromotion($rootNode->children());

        return $treeBuilder;
    }

    /**
     * @param NodeBuilder $rootNodeBuilder
     */
    private function addCatalogPromotion(NodeBuilder $rootNodeBuilder)
    {
        $rootNodeBuilder
            ->arrayNode('resources')
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('catalog_promotion')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('classes')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue(CatalogPromotion::class)->cannotBeEmpty()->end()
                                ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                ->scalarNode('repository')->defaultValue(CatalogPromotionRepository::class)->cannotBeEmpty()->end()
                                ->scalarNode('form')->defaultValue(CatalogPromotionType::class)->cannotBeEmpty()->end()
                                ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
        ;
    }
}
