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

    const ERROR_MSG_ETA_NOT_FOUND = "ETA not found for product %s";
    const ERROR_MSG_NO_CRITERIA_OR_WEEKS_NUMBER_ITEMS_FOUND =
        "Wrong rule configuration. No criteria or weeks number items found";

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
        $etaAttribute = $productVariant->getProduct()->getAttributeByCodeAndLocale(
            self::PRODUCT_ATTRIBUTE_DELIVERY_TIME
        );

        if (!($etaAttribute instanceof AttributeValueInterface)) {
            throw new CatalogPromotionRuleException(
                sprintf(
                    self::ERROR_MSG_ETA_NOT_FOUND,
                    $productVariant->getProduct()->getId()
                )
            );
        }

        $etaInWeeks = intval(ceil($etaAttribute->getValue() / 7));

        if (!isset($configuration['criteria']) || !isset($configuration['weeks'])) {
            throw new CatalogPromotionRuleException(self::ERROR_MSG_NO_CRITERIA_OR_WEEKS_NUMBER_ITEMS_FOUND);
        }

        return $this->validateElegibility($configuration['criteria'], $etaInWeeks, $configuration['weeks']);
    }

    /**
     * @param string $criteria
     * @param int    $etaInWeeks
     * @param int    $referenceDeliveryWeeks
     *
     * @return bool
     */
    private function validateElegibility(string $criteria, int $etaInWeeks, int $referenceDeliveryWeeks)
    {
        if ($criteria == self::CRITERIA_MORE) {
            return $this->isGreaterThan($etaInWeeks, $referenceDeliveryWeeks);
        }
        if ($criteria == self::CRITERIA_EQUAL) {
            return $this->isEqualsTo($etaInWeeks, $referenceDeliveryWeeks);
        }
        if ($criteria == self::CRITERIA_LESS) {
            return $this->isLessThan($etaInWeeks, $referenceDeliveryWeeks);
        }

        return false;
    }

    /**
     * @param int $etaInWeeks
     * @param int $referenceDeliveryWeeks
     *
     * @return bool
     */
    private function isGreaterThan(int $etaInWeeks, int $referenceDeliveryWeeks)
    {
        return $etaInWeeks > $referenceDeliveryWeeks;
    }

    /**
     * @param int $etaInWeeks
     * @param int $referenceDeliveryWeeks
     *
     * @return bool
     */
    private function isEqualsTo(int $etaInWeeks, int $referenceDeliveryWeeks)
    {
        return $etaInWeeks == $referenceDeliveryWeeks;
    }

    /**
     * @param int $etaInWeeks
     * @param int $referenceDeliveryWeeks
     *
     * @return bool
     */
    private function isLessThan(int $etaInWeeks, int $referenceDeliveryWeeks)
    {
        return $etaInWeeks < $referenceDeliveryWeeks;
    }
}
