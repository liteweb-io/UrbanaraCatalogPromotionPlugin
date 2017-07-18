<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Urbanara\CatalogPromotionPlugin\ElasticSearch\Document\ProductDocument;
use Urbanara\CatalogPromotionPlugin\ElasticSearch\View as ElasticSearchView;
use Urbanara\CatalogPromotionPlugin\ShopApi\View as ShopApiView;

final class CatalogPromotionExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $this->registerResources('urbanara_catalog_promotion', SyliusResourceBundle::DRIVER_DOCTRINE_ORM, $config['resources'], $container);

        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $container->getExtensionConfig($this->getAlias()));
        $this->registerResources('urbanara_catalog_promotion', SyliusResourceBundle::DRIVER_DOCTRINE_ORM, $config['resources'], $container);

        $this->prependElasticSearchPlugin($container);
        $this->prependShopApiPlugin($container);
    }

    private function prependElasticSearchPlugin(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('sylius_elastic_search', [
            'document_classes' => [
                'product' => ProductDocument::class,
            ],
            'view_classes' => [
                'product_variant' => ElasticSearchView\VariantView::class,
                'price' => ElasticSearchView\PriceView::class,
            ],
        ]);
    }

    private function prependShopApiPlugin(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('shop_api', [
            'view_classes' => [
                'price' => ShopApiView\PriceView::class,
                'product_variant' => ShopApiView\ProductVariantView::class,
            ],
        ]);
    }
}
