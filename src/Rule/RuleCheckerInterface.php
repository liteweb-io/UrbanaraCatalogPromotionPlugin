<?php

namespace Acme\SyliusCatalogPromotionPlugin\Rule;

use Sylius\Component\Core\Model\ProductVariantInterface;

interface RuleCheckerInterface
{
    /**
     * @return string
     */
    public function getConfigurationFormType();

    /**
     * @param ProductVariantInterface $productVariant
     * @param array $configuration
     *
     * @return bool
     */
    public function isEligible(ProductVariantInterface $productVariant, array $configuration);
}
