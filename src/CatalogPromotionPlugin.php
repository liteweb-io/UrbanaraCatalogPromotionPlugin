<?php

namespace Urbanara\CatalogPromotionPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Urbanara\CatalogPromotionPlugin\DependencyInjection\Compiler\RegisterCatalogPromotionActionsPass;
use Urbanara\CatalogPromotionPlugin\DependencyInjection\Compiler\RegisterCatalogPromotionRulesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class CatalogPromotionPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterCatalogPromotionActionsPass());
        $container->addCompilerPass(new RegisterCatalogPromotionRulesPass());
    }
}
