<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\Rule;

use Acme\SyliusCatalogPromotionPlugin\Form\Type\Rule\IsProductType;
use Acme\SyliusCatalogPromotionPlugin\Rule\IsProductRuleChecker;
use Acme\SyliusCatalogPromotionPlugin\Rule\RuleCheckerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductInterface;

final class IsProductRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IsProductRuleChecker::class);
    }

    function it_is_a_rule_checker()
    {
        $this->shouldHaveType(RuleCheckerInterface::class);
    }

    function it_has_related_configuration_type()
    {
        $this->getConfigurationFormType()->shouldReturn(IsProductType::class);
    }

    function it_returns_true_if_promotion_is_eligible(OrderItemInterface $orderItem, ProductInterface $product)
    {
        $orderItem->getProduct()->willReturn($product);
        $product->getCode()->willReturn('PUG-CODE');

        $this->isEligible($orderItem, ['products' => ['PUG-CODE']])->shouldReturn(true);
    }

    function it_returns_false_if_promotion_is_not_eligible(OrderItemInterface $orderItem, ProductInterface $product)
    {
        $orderItem->getProduct()->willReturn($product);
        $product->getCode()->willReturn('NARWHAL-CODE');

        $this->isEligible($orderItem, ['products' => ['PUG-CODE']])->shouldReturn(false);
    }
}
