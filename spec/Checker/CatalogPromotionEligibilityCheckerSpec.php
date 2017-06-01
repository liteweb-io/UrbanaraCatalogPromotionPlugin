<?php

declare(strict_types=1);

namespace spec\Urbanara\CatalogPromotionPlugin\Checker;

use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Urbanara\CatalogPromotionPlugin\Checker\EligibilityCheckerInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogRuleInterface;
use Urbanara\CatalogPromotionPlugin\Rule\RuleCheckerInterface;

final class CatalogPromotionEligibilityCheckerSpec extends ObjectBehavior
{
    function let(ServiceRegistryInterface $ruleRegistry, LoggerInterface $logger)
    {
        $this->beConstructedWith($ruleRegistry, $logger);
    }

    function it_is_eligibility_checker()
    {
        $this->shouldImplement(EligibilityCheckerInterface::class);
    }

    function it_checks_eligibility_of_the_promotion(
        CatalogPromotionInterface $catalogPromotion,
        ProductVariantInterface $productVariant,
        CatalogRuleInterface $eligibleRule,
        RuleCheckerInterface $ruleChecker,
        ServiceRegistryInterface $ruleRegistry
    ) {
        $catalogPromotion->getRules()->willReturn([$eligibleRule]);
        $eligibleRule->getType()->willReturn('identifier');
        $eligibleRule->getConfiguration()->willReturn([]);
        $ruleRegistry->get('identifier')->willReturn($ruleChecker);
        $ruleChecker->isEligible($productVariant, [])->willReturn(true);

        $this->isEligible($productVariant, $catalogPromotion)->shouldReturn(true);
    }

    function it_returns_true_if_no_rules_defined(
        CatalogPromotionInterface $catalogPromotion,
        ProductVariantInterface $productVariant
    ) {
        $catalogPromotion->getRules()->willReturn([]);

        $this->isEligible($productVariant, $catalogPromotion)->shouldReturn(true);
    }

    function it_returns_false_if_some_of_rules_is_not_fulfilled(
        CatalogPromotionInterface $catalogPromotion,
        ProductVariantInterface $productVariant,
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
        $ruleChecker->isEligible($productVariant, [])->willReturn(true, false);

        $this->isEligible($productVariant, $catalogPromotion)->shouldReturn(false);
    }
}
