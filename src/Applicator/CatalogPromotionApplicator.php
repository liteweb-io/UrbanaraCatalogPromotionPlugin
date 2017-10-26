<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Applicator;

use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\Model\CatalogAdjustmentInterface;
use Sylius\Component\Order\Model\AdjustmentInterface;
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
     * {@inheritdoc}
     */
    public function apply(OrderItemInterface $orderItem, CatalogPromotionInterface $catalogPromotion, $amount, $label = '')
    {
        $adjustment = $this->provideAdjustment($orderItem, $catalogPromotion);
        $adjustment->setAmount($amount);
        $adjustment->setLabel($label);
        $adjustment->setNeutral(true);

        $orderItem->addAdjustment($adjustment);
        $orderItem->setUnitPrice($orderItem->getUnitPrice() - $amount);
    }

    private function provideAdjustment(
        OrderItemInterface $orderItem,
        CatalogPromotionInterface $catalogPromotion
    ): AdjustmentInterface {
        $adjustments = $orderItem->getAdjustments(CatalogAdjustmentInterface::CATALOG_PROMOTION_ADJUSTMENT);
        foreach ($adjustments as $adjustment) {
            if ($adjustment->getOriginCode() === $catalogPromotion->getCode()) {
                return $adjustment;
            }
        }

        /** @var AdjustmentInterface $adjustment */
        $adjustment = $this->adjustmentFactory->createNew();
        $adjustment->setType(CatalogAdjustmentInterface::CATALOG_PROMOTION_ADJUSTMENT);
        $adjustment->setOriginCode($catalogPromotion->getCode());

        return $adjustment;
    }
}
