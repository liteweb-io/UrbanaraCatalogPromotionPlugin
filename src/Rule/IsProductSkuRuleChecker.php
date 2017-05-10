<?php

namespace Urbanara\CatalogPromotionPlugin\Rule;

use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Urbanara\CatalogPromotionPlugin\Exception\CatalogPromotionRuleException;
use Urbanara\CatalogPromotionPlugin\Form\Type\Rule\IsProductSkuType;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class IsProductSkuRuleChecker implements RuleCheckerInterface
{
    const TYPE = 'is_product_sku';
    const PRODUCT_ATTRIBUTE_SKU = 'sku';

    const ERROR_MSG_NO_SKU_LIST_FOUND_IN_RULE = 'No product SKU list found in rule criteria';
    const ERROR_MSG_NO_SKU_FOUND_IN_PRODUCT = 'No SKU found in product';

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return IsProductSkuType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function isEligible(ProductVariantInterface $productVariant, array $configuration)
    {
        if (empty($configuration[IsProductSkuType::FORM_ELEMENT_NAME_PRODUCT_SKU_LIST])) {
            throw new CatalogPromotionRuleException(
                sprintf('%s: %s', self::class, self::ERROR_MSG_NO_SKU_LIST_FOUND_IN_RULE)
            );
        }

        $lookedUpSkuAttribute =
            $productVariant->getProduct()->getAttributeByCodeAndLocale(self::PRODUCT_ATTRIBUTE_SKU);

        if (!($lookedUpSkuAttribute instanceof AttributeValueInterface) || !$lookedUpSkuAttribute->getValue()) {
            throw new CatalogPromotionRuleException(
                sprintf('%s: %s', self::class, self::ERROR_MSG_NO_SKU_FOUND_IN_PRODUCT)
            );
        }

        return (bool) preg_match(
            "/\b{$lookedUpSkuAttribute->getValue()}\b/",
            $configuration[IsProductSkuType::FORM_ELEMENT_NAME_PRODUCT_SKU_LIST]
        );
    }
}
