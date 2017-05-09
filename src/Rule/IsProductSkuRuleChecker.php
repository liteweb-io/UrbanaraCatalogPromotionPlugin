<?php

namespace Urbanara\CatalogPromotionPlugin\Rule;

use Urbanara\CatalogPromotionPlugin\Exception\CatalogPromotionRuleException;
use Urbanara\CatalogPromotionPlugin\Form\Type\Rule\IsProductSkuType;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class IsProductSkuRuleChecker implements RuleCheckerInterface
{
    const TYPE = 'is_product_sku';

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
        if (empty($configuration['sku_list'])) {
            throw new CatalogPromotionRuleException(self::class . ': No product SKU list found in rule criteria.');
        }

        $decodedSkuList = \json_decode($configuration['sku_list']);
        if (json_last_error() || empty($decodedSkuList)) {
            throw new CatalogPromotionRuleException(self::class . ': Invalid product SKU list in rule criteria.');
        }

        return in_array($productVariant->getProduct()->getAttributeByCodeAndLocale('sku'), $decodedSkuList, true);
    }
}
