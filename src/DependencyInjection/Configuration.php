<?php

namespace Urbanara\CatalogPromotionPlugin\DependencyInjection;

use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotion;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogRule;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogRuleInterface;
use Urbanara\CatalogPromotionPlugin\Form\Type\CatalogRuleType;
use Urbanara\CatalogPromotionPlugin\Form\Type\CatalogPromotionType;
use Urbanara\CatalogPromotionPlugin\Repository\CatalogPromotionRepository;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
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
        $rootNode = $treeBuilder->root('urbanara_catalog_promotion');

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
                                ->scalarNode('interface')->defaultValue(CatalogPromotionInterface::class)->cannotBeEmpty()->end()
                                ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                ->scalarNode('repository')->defaultValue(CatalogPromotionRepository::class)->cannotBeEmpty()->end()
                                ->scalarNode('form')->defaultValue(CatalogPromotionType::class)->cannotBeEmpty()->end()
                                ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('catalog_rule')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('classes')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue(CatalogRule::class)->cannotBeEmpty()->end()
                                ->scalarNode('interface')->defaultValue(CatalogRuleInterface::class)->cannotBeEmpty()->end()
                                ->scalarNode('form')->defaultValue(CatalogRuleType::class)->cannotBeEmpty()->end()
                                ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
        ;
    }
}
