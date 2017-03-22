<?php

namespace Tests\Acme\SyliusCatalogPromotionPlugin\DependencyInjection\Compiler;

use Acme\SyliusCatalogPromotionPlugin\DependencyInjection\Compiler\RegisterCatalogPromotionActionsPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterCatalogPromotionActionsPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function it_registers_collected_catalog_promotion_actions_in_the_registry()
    {
        $this->setDefinition('acme_sylius_catalog_promotion.registry_catalog_promotion_action', new Definition());
        $this->setDefinition(
            'custom_catalog_promotion_action_command',
            (new Definition())->addTag('acme_sylius_catalog_promotion.catalog_promotion_action', ['type' => 'custom', 'label' => 'Label'])
        );

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'acme_sylius_catalog_promotion.registry_catalog_promotion_action',
            'register',
            ['custom', new Reference('custom_catalog_promotion_action_command')]
        );
    }

    /**
     * @test
     */
    public function it_creates_parameter_which_maps_catalog_promotion_action_type_to_label()
    {
        $this->setDefinition('acme_sylius_catalog_promotion.registry_catalog_promotion_action', new Definition());
        $this->setDefinition(
            'custom_promotion_action_command',
            (new Definition())->addTag('acme_sylius_catalog_promotion.catalog_promotion_action', ['type' => 'custom', 'label' => 'Label', 'form-type' => 'FQCN'])
        );

        $this->compile();

        $this->assertContainerBuilderHasParameter(
            'acme_sylius_catalog_promotion.catalog_promotion_actions',
            ['custom' => 'Label']
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterCatalogPromotionActionsPass());
    }
}
