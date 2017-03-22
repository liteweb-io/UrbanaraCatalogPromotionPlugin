<?php

namespace Acme\SyliusCatalogPromotionPlugin\Checker;

use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

interface EligibilityCheckerInterface
{
    /**
     * @param OrderItemInterface $orderItem
     * @param CatalogPromotionInterface $catalogPromotion
     *
     * @return bool
     */
    public function isEligible(OrderItemInterface $orderItem, CatalogPromotionInterface $catalogPromotion);
}