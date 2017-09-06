<?php

declare(strict_types=1);

namespace spec\Urbanara\CatalogPromotionPlugin\Applicator;

use Doctrine\Common\Collections\ArrayCollection;
use Urbanara\CatalogPromotionPlugin\Applicator\CatalogPromotionApplicator;
use Urbanara\CatalogPromotionPlugin\Applicator\CatalogPromotionApplicatorInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\Model\CatalogAdjustmentInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class CatalogPromotionApplicatorSpec extends ObjectBehavior
{
    function let(FactoryInterface $adjustmentFactory)
    {
        $this->beConstructedWith($adjustmentFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CatalogPromotionApplicator::class);
    }

    function it_is_an_applicator()
    {
        $this->shouldHaveType(CatalogPromotionApplicatorInterface::class);
    }

    function it_applies_a_new_catalog_discount_to_order_item(
        AdjustmentInterface $adjustment,
        AdjustmentInterface $anotherAdjustment,
        CatalogPromotionInterface $catalogPromotion,
        FactoryInterface $adjustmentFactory,
        OrderItemInterface $orderItem
    ) {
        $anotherAdjustment->getType()->willReturn(CatalogAdjustmentInterface::CATALOG_PROMOTION_ADJUSTMENT);
        $anotherAdjustment->getOriginCode()->willReturn('BAZ');

        $orderItem->getUnitPrice()->willReturn(1000);
        $orderItem->getAdjustments(CatalogAdjustmentInterface::CATALOG_PROMOTION_ADJUSTMENT)->willReturn(new ArrayCollection([
            $anotherAdjustment->getWrappedObject()
        ]));

        $catalogPromotion->getCode()->willReturn('FOOBAR');

        $adjustmentFactory->createNew()->willReturn($adjustment);

        $adjustment->setNeutral(true)->shouldBeCalled();
        $adjustment->setType(CatalogAdjustmentInterface::CATALOG_PROMOTION_ADJUSTMENT)->shouldBeCalled();
        $adjustment->setOriginCode('FOOBAR')->shouldBeCalled();
        $adjustment->setAmount(100)->shouldBeCalled();
        $adjustment->setLabel('Nice promotion')->shouldBeCalled();

        $orderItem->addAdjustment($adjustment)->shouldBeCalled();
        $orderItem->setUnitPrice(900)->shouldBeCalled();

        $this->apply($orderItem, $catalogPromotion, 100, 'Nice promotion');
    }

    function it_reapplies_an_existing_catalog_discount_to_order_item(
        AdjustmentInterface $adjustment,
        CatalogPromotionInterface $catalogPromotion,
        OrderItemInterface $orderItem
    ) {
        $adjustment->getType()->willReturn(CatalogAdjustmentInterface::CATALOG_PROMOTION_ADJUSTMENT);
        $adjustment->getOriginCode()->willReturn('FOOBAR');

        $orderItem->getUnitPrice()->willReturn(1000);
        $orderItem->getAdjustments(CatalogAdjustmentInterface::CATALOG_PROMOTION_ADJUSTMENT)->willReturn(new ArrayCollection([
            $adjustment->getWrappedObject()
        ]));

        $catalogPromotion->getCode()->willReturn('FOOBAR');

        $adjustment->setNeutral(true)->shouldBeCalled();
        $adjustment->setAmount(100)->shouldBeCalled();
        $adjustment->setLabel('Nice promotion')->shouldBeCalled();

        $orderItem->addAdjustment($adjustment)->shouldBeCalled();
        $orderItem->setUnitPrice(900)->shouldBeCalled();

        $this->apply($orderItem, $catalogPromotion, 100, 'Nice promotion');
    }
}
