<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Urbanara\CatalogPromotionPlugin\ElasticSearch\Controller\PriceView;
use Urbanara\CatalogPromotionPlugin\ElasticSearch\Controller\VariantView;
use Urbanara\CatalogPromotionPlugin\ElasticSearch\Document\ProductDocument;

final class CatalogPromotionExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $this->registerResources('urbanara_catalog_promotion', SyliusResourceBundle::DRIVER_DOCTRINE_ORM, $config['resources'], $container);

        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $container->getExtensionConfig($this->getAlias()));
        $this->registerResources('urbanara_catalog_promotion', SyliusResourceBundle::DRIVER_DOCTRINE_ORM, $config['resources'], $container);

        $container->prependExtensionConfig('sylius_elastic_search', [
            'document_classes' => [
                'product' => ProductDocument::class,
            ],
            'view_classes' => [
                'product_variant' => VariantView::class,
                'price' => PriceView::class,
            ],
        ]);
    }
}
