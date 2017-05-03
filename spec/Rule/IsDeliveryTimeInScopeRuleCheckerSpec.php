<?php

namespace spec\Urbanara\CatalogPromotionPlugin\Rule;

use Urbanara\CatalogPromotionPlugin\Form\Type\Rule\IsProductType;
use Urbanara\CatalogPromotionPlugin\Rule\IsDeliveryTimeInScopeRuleChecker;
use Urbanara\CatalogPromotionPlugin\Rule\RuleCheckerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\ProductInterface;

final class IsDeliveryTimeInScopeRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IsDeliveryTimeInScopeRuleChecker::class);
    }

    function it_is_a_rule_checker()
    {
        $this->shouldHaveType(RuleCheckerInterface::class);
    }

    function it_has_related_configuration_type()
    {
        $this->getConfigurationFormType()->shouldReturn(IsProductType::class);
    }

    function it_returns_true_if_promotion_is_eligible(ProductVariantInterface $productVariant, ProductInterface $product)
    {
        $productVariant->getProduct()->willReturn($product);
        $product->getCode()->willReturn('PUG-CODE');

        $this->isEligible($productVariant, ['products' => ['PUG-CODE']])->shouldReturn(true);
    }

    function it_returns_false_if_promotion_is_not_eligible(ProductVariantInterface $productVariant, ProductInterface $product)
    {
        $productVariant->getProduct()->willReturn($product);
        $product->getCode()->willReturn('NARWHAL-CODE');

        $this->isEligible($productVariant, ['products' => ['PUG-CODE']])->shouldReturn(false);
    }
}
