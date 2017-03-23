<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\Checker;

use Acme\SyliusCatalogPromotionPlugin\Checker\CatalogPromotionEligibilityChecker;
use Acme\SyliusCatalogPromotionPlugin\Checker\EligibilityCheckerInterface;
use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogRuleInterface;
use Acme\SyliusCatalogPromotionPlugin\Rule\RuleCheckerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class CatalogPromotionEligibilityCheckerSpec extends ObjectBehavior
{
    function let(ServiceRegistryInterface $ruleRegistry)
    {
        $this->beConstructedWith($ruleRegistry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CatalogPromotionEligibilityChecker::class);
    }

    function it_is_eligibility_checker()
    {
        $this->shouldImplement(EligibilityCheckerInterface::class);
    }

    function it_checks_eligibility_of_the_promotion(
        CatalogPromotionInterface $catalogPromotion,
        OrderItemInterface $orderItem,
        CatalogRuleInterface $eligibleRule,
        RuleCheckerInterface $ruleChecker,
        ServiceRegistryInterface $ruleRegistry
    ) {
        $catalogPromotion->getRules()->willReturn([$eligibleRule]);
        $eligibleRule->getType()->willReturn('identifier');
        $eligibleRule->getConfiguration()->willReturn([]);
        $ruleRegistry->get('identifier')->willReturn($ruleChecker);
        $ruleChecker->isEligible($orderItem, [])->willReturn(true);

        $this->isEligible($orderItem, $catalogPromotion)->shouldReturn(true);
    }

    function it_returns_true_if_no_rules_defined(
        CatalogPromotionInterface $catalogPromotion,
        OrderItemInterface $orderItem
    ) {
        $catalogPromotion->getRules()->willReturn([]);

        $this->isEligible($orderItem, $catalogPromotion)->shouldReturn(true);
    }

    function it_returns_false_if_any_of_rules_is_not_fulfilled(
        CatalogPromotionInterface $catalogPromotion,
        OrderItemInterface $orderItem,
        CatalogRuleInterface $eligibleRule,
        CatalogRuleInterface $notEligibleRule,
        RuleCheckerInterface $ruleChecker,
        ServiceRegistryInterface $ruleRegistry
    ) {
        $catalogPromotion->getRules()->willReturn([$eligibleRule, $notEligibleRule]);

        $eligibleRule->getType()->willReturn('identifier');
        $eligibleRule->getConfiguration()->willReturn([]);

        $notEligibleRule->getType()->willReturn('identifier');
        $notEligibleRule->getConfiguration()->willReturn([]);

        $ruleRegistry->get('identifier')->willReturn($ruleChecker);
        $ruleChecker->isEligible($orderItem, [])->willReturn(true, false);

        $this->isEligible($orderItem, $catalogPromotion)->shouldReturn(false);
    }
}
