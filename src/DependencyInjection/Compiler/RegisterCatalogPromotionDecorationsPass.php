<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterCatalogPromotionDecorationsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('urbanara_catalog_promotion.catalog_promotion_decoration.form_registry')) {
            return;
        }

        $formRegistry = $container->getDefinition('urbanara_catalog_promotion.catalog_promotion_decoration.form_registry');
        $decorations = [];

        $decorationsServices = $container->findTaggedServiceIds('urbanara_catalog_promotion.catalog_promotion_decoration');
        foreach ($decorationsServices as $id => $attributes) {
            if (!isset($attributes[0]['type'], $attributes[0]['label'], $attributes[0]['form-type'])) {
                throw new \InvalidArgumentException('Tagged promotion decoration needs to have `type`, `label` and `form-type` attributes.');
            }

            $decorations[$attributes[0]['type']] = $attributes[0]['label'];

            $formRegistry->addMethodCall('add', [$attributes[0]['type'], 'default', $attributes[0]['form-type']]);
        }

        $container->setParameter('urbanara_catalog_promotion.catalog_promotion_decorations', $decorations);
    }
}
