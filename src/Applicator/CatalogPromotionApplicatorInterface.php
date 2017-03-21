<?php

namespace Acme\SyliusCatalogPromotionPlugin\Applicator;

use Sylius\Component\Core\Model\OrderItemInterface;

interface CatalogPromotionApplicatorInterface
{
    /**
     * @param OrderItemInterface $orderItem
     * @param int $amount
     * @param string $label
     */
    public function apply(OrderItemInterface $orderItem, $amount, $label = '');
}
