<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\Rule;

use Acme\SyliusCatalogPromotionPlugin\Form\Type\Rule\IsProductType;
use Acme\SyliusCatalogPromotionPlugin\Rule\IsProductRuleChecker;
use Acme\SyliusCatalogPromotionPlugin\Rule\RuleCheckerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
}
