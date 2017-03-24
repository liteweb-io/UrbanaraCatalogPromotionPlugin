<?php

namespace Urbanara\CatalogPromotionPlugin\Applicator;

use Urbanara\CatalogPromotionPlugin\Model\CatalogAdjustmentInterface;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class CatalogPromotionApplicator implements CatalogPromotionApplicatorInterface
{
    /**
     * @var FactoryInterface
     */
    private $adjustmentFactory;

    /**
     * @param FactoryInterface $adjustmentFactory
     */
    public function __construct(FactoryInterface $adjustmentFactory)
    {
        $this->adjustmentFactory = $adjustmentFactory;
    }

    /**
     * @param OrderItemInterface $orderItem
     * @param int $amount
     * @param string $label
     */
    public function apply(OrderItemInterface $orderItem, $amount, $label = '')
    {
        /** @var AdjustmentInterface $adjustment */
        $adjustment = $this->adjustmentFactory->createNew();
        $adjustment->setType(CatalogAdjustmentInterface::CATALOG_PROMOTION_ADJUSTMENT);
        $adjustment->setAmount($amount);
        $adjustment->setLabel($label);
        $adjustment->setNeutral(true);

        $orderItem->addAdjustment($adjustment);
        $orderItem->setUnitPrice($orderItem->getUnitPrice() - $amount);
    }
}
