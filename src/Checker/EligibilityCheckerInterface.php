<?php

namespace Urbanara\CatalogPromotionPlugin\Checker;

use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

interface EligibilityCheckerInterface
{
    /**
     * @param ProductVariantInterface $productVariant
     * @param CatalogPromotionInterface $catalogPromotion
     *
     * @return bool
     */
    public function isEligible(ProductVariantInterface $productVariant, CatalogPromotionInterface $catalogPromotion);
}
