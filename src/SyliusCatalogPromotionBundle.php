<?php

namespace Acme\SyliusCatalogPromotionBundle;

use Acme\SyliusCatalogPromotionBundle\DependencyInjection\Compiler\RegisterCatalogPromotionActionsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusCatalogPromotionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterCatalogPromotionActionsPass());
    }
}
