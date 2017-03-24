<?php

namespace Urbanara\CatalogPromotionPlugin\Rule;

use Urbanara\CatalogPromotionPlugin\Form\Type\Rule\IsFromTaxonType;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class IsFromTaxonRuleChecker implements RuleCheckerInterface
{
    const TYPE = 'is_from_taxon';

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return IsFromTaxonType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function isEligible(ProductVariantInterface $productVariant, array $configuration)
    {
        /** @var ProductInterface $product */
        $product = $productVariant->getProduct();

        foreach ($product->getTaxons() as $taxon) {
            if (in_array($taxon->getCode(), $configuration['taxons'], true)) {
                return true;
            }
        }

        return false;
    }
}
