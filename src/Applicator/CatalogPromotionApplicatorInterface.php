<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Applicator;

use Sylius\Component\Core\Model\OrderItemInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;

interface CatalogPromotionApplicatorInterface
{
    /**
     * @param OrderItemInterface $orderItem
     * @param CatalogPromotionInterface $catalogPromotion
     * @param int $amount
     * @param string $label
     */
    public function apply(OrderItemInterface $orderItem, CatalogPromotionInterface $catalogPromotion, $amount, $label = '');
}
