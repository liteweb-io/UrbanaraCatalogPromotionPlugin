<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\Rule;

use Acme\SyliusCatalogPromotionPlugin\Form\Type\Rule\IsFromTaxonType;
use Acme\SyliusCatalogPromotionPlugin\Rule\RuleCheckerInterface;
use Acme\SyliusCatalogPromotionPlugin\Rule\IsFromTaxonRuleChecker;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;

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

    function it_returns_true_if_promotion_is_eligible(
        ProductVariantInterface $productVariant,
        ProductInterface $product,
        TaxonInterface $taxon
    ) {
        $productVariant->getProduct()->willReturn($product);
        $product->getTaxons()->willReturn([$taxon]);
        $taxon->getCode()->willReturn('PUG-CODE');

        $this->isEligible($productVariant, ['taxons' => ['PUG-CODE']])->shouldReturn(true);
    }

    function it_returns_true_if_at_least_one_of_taxons_fulfill_criteria(
        ProductVariantInterface $productVariant,
        ProductInterface $product,
        TaxonInterface $badTaxon,
        TaxonInterface $goodTaxon
    ) {
        $productVariant->getProduct()->willReturn($product);
        $product->getTaxons()->willReturn([$badTaxon, $goodTaxon]);
        $badTaxon->getCode()->willReturn('NARWHAL-CODE');
        $goodTaxon->getCode()->willReturn('PUG-CODE');

        $this->isEligible($productVariant, ['taxons' => ['PUG-CODE']])->shouldReturn(true);
    }

    function it_returns_false_if_promotion_is_not_eligible(
        ProductVariantInterface $productVariant,
        ProductInterface $product,
        TaxonInterface $taxon
    ) {
        $productVariant->getProduct()->willReturn($product);
        $product->getTaxons()->willReturn([$taxon]);
        $taxon->getCode()->willReturn('NARWHAL-CODE');

        $this->isEligible($productVariant, ['taxons' => ['PUG-CODE']])->shouldReturn(false);
    }
}
