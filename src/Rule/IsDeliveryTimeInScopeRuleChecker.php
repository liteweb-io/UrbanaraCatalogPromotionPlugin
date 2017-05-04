<?php

namespace Urbanara\CatalogPromotionPlugin\Rule;

use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Urbanara\CatalogPromotionPlugin\Exception\CatalogPromotionRuleException;
use Urbanara\CatalogPromotionPlugin\Form\Type\Rule\IsProductDeliveryTimeInScopeType;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class IsDeliveryTimeInScopeRuleChecker implements RuleCheckerInterface
{
    const TYPE = 'is_product_delivery_time_in_scope';

    const PRODUCT_ATTRIBUTE_DELIVERY_TIME = 'eta';

    const CRITERIA_MORE = 'more';
    const CRITERIA_LESS = 'less';
    const CRITERIA_EQUAL = 'equal';

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return IsProductDeliveryTimeInScopeType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function isEligible(ProductVariantInterface $productVariant, array $configuration)
    {
        $isElegible = false;
        $etaAttribute = $productVariant->getProduct()->getAttributeByCodeAndLocale(
            self::PRODUCT_ATTRIBUTE_DELIVERY_TIME
        );

        if (!($etaAttribute instanceof AttributeValueInterface)) {
            throw new CatalogPromotionRuleException(sprintf("ETA not found for product %s", $productVariant->getProduct()->getId()));
        }

        $etaInWeeks = intval($etaAttribute->getValue());

        if (!isset($configuration['criteria']) || !isset($configuration['weeks'])) {
            throw new CatalogPromotionRuleException("Wrong rule configuration. No criteria or weeks number items found");
        }

        $referenceDeliveryWeeks = $configuration['weeks'];

        switch ($configuration['criteria']) {
            case self::CRITERIA_MORE:
                $isElegible = ($etaInWeeks > $referenceDeliveryWeeks);
                break;
            case self::CRITERIA_LESS:
                $isElegible = ($etaInWeeks < $referenceDeliveryWeeks);
                break;
            case self::CRITERIA_EQUAL:
                $isElegible = ($etaInWeeks == $referenceDeliveryWeeks);
                break;
        }

        return $isElegible;
    }
}
