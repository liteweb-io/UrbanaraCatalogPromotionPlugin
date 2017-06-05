<?php

declare(strict_types=1);

namespace Tests\Urbanara\CatalogPromotionPlugin\DependencyInjection\Compiler;

use Urbanara\CatalogPromotionPlugin\DependencyInjection\Compiler\RegisterCatalogPromotionRulesPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterCatalogPromotionRulesPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function it_registers_collected_catalog_promotion_rules_in_the_registry()
    {
        $this->setDefinition('urbanara_catalog_promotion.registry_catalog_promotion_rule', new Definition());
        $this->setDefinition(
            'custom_catalog_promotion_rule_command',
            (new Definition())->addTag('urbanara_catalog_promotion.catalog_promotion_rule', ['type' => 'custom', 'label' => 'Label'])
        );

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'urbanara_catalog_promotion.registry_catalog_promotion_rule',
            'register',
            ['custom', new Reference('custom_catalog_promotion_rule_command')]
        );
    }

    /**
     * @test
     */
    public function it_creates_parameter_which_maps_catalog_promotion_rule_type_to_label()
    {
        $this->setDefinition('urbanara_catalog_promotion.registry_catalog_promotion_rule', new Definition());
        $this->setDefinition(
            'custom_promotion_rule_command',
            (new Definition())->addTag('urbanara_catalog_promotion.catalog_promotion_rule', ['type' => 'custom', 'label' => 'Label', 'form-type' => 'FQCN'])
        );

        $this->compile();

        $this->assertContainerBuilderHasParameter(
            'urbanara_catalog_promotion.catalog_promotion_rules',
            ['custom' => 'Label']
        );
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterCatalogPromotionRulesPass());
    }
}
