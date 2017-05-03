<?php

namespace Urbanara\CatalogPromotionPlugin\Rule;

use Urbanara\CatalogPromotionPlugin\Form\Type\Rule\IsProductType;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class IsDeliveryTimeInScopeRuleChecker implements RuleCheckerInterface
{
    const TYPE = 'is_product';

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return IsProductType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function isEligible(ProductVariantInterface $productVariant, array $configuration)
    {
        return in_array($productVariant->getProduct()->getCode(), $configuration['products'], true);
    }
}
