<?php

namespace Acme\SyliusCatalogPromotionPlugin\Rule;

use Acme\SyliusCatalogPromotionPlugin\Form\Type\Rule\IsFromTaxonType;
use Sylius\Component\Core\Model\OrderItemInterface;

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
    public function isEligible(OrderItemInterface $orderItem, array $configuration)
    {
        $product = $orderItem->getProduct();

        foreach ($product->getTaxons() as $taxon) {
            if (in_array($taxon->getCode(), $configuration['taxons'], true)) {
                return true;
            }
        }

        return false;
    }
}
