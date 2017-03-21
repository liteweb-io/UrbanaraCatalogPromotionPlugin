<?php

namespace Acme\SyliusCatalogPromotionPlugin;

use Acme\SyliusCatalogPromotionPlugin\DependencyInjection\Compiler\RegisterCatalogPromotionActionsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusCatalogPromotionPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterCatalogPromotionActionsPass());
    }
}
