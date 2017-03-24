<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\Rule;

use Acme\SyliusCatalogPromotionPlugin\Form\Type\Rule\IsFromTaxonType;
use Acme\SyliusCatalogPromotionPlugin\Rule\RuleCheckerInterface;
use Acme\SyliusCatalogPromotionPlugin\Rule\IsFromTaxonRuleChecker;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class IsFromTaxonRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IsFromTaxonRuleChecker::class);
    }

    function it_is_a_rule_checker()
    {
        $this->shouldHaveType(RuleCheckerInterface::class);
    }

    function it_has_related_configuration_type()
    {
        $this->getConfigurationFormType()->shouldReturn(IsFromTaxonType::class);
    }
}
