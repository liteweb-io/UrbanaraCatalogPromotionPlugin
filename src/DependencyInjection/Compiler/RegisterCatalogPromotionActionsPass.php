<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterCatalogPromotionActionsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('urbanara_catalog_promotion.registry_catalog_promotion_action')) {
            return;
        }

        $registry = $container->getDefinition('urbanara_catalog_promotion.registry_catalog_promotion_action');
        $actions = [];

        $actionsServices = $container->findTaggedServiceIds('urbanara_catalog_promotion.catalog_promotion_action');
        ksort($actionsServices);

        foreach ($actionsServices as $id => $attributes) {
            if (!isset($attributes[0]['type']) || !isset($attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged promotion action needs to have `type` and `label` attributes.');
            }

            $actions[$attributes[0]['type']] = $attributes[0]['label'];

            $registry->addMethodCall('register', [$attributes[0]['type'], new Reference($id)]);
        }

//        $container->setParameter('urbanara_catalog_promotion.catalog_promotion_actions', $actions);
        $container->setParameter('urbanara_catalog_promotion.catalog_promotion_actions',  ['custom' => 'Label']);
    }
}
