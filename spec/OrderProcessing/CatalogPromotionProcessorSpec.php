<?php

declare(strict_types=1);

namespace spec\Urbanara\CatalogPromotionPlugin\OrderProcessing;

use Urbanara\CatalogPromotionPlugin\Action\CatalogDiscountActionCommandInterface;
use Urbanara\CatalogPromotionPlugin\Applicator\CatalogPromotionApplicatorInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\OrderProcessing\CatalogPromotionProcessor;
use Urbanara\CatalogPromotionPlugin\Provider\CatalogPromotionProviderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Registry\ServiceRegistry;

final class CatalogPromotionProcessorSpec extends ObjectBehavior
{
    function let(
        CatalogPromotionProviderInterface $catalogPromotionProvider,
        ServiceRegistry $catalogActionRegistry,
        CatalogPromotionApplicatorInterface $catalogPromotionApplicator
    ) {
        $this->beConstructedWith($catalogPromotionProvider, $catalogActionRegistry, $catalogPromotionApplicator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CatalogPromotionProcessor::class);
    }

    function it_is_order_processor()
    {
        $this->shouldImplement(OrderProcessorInterface::class);
    }

    function it_process_order_items_in_order_to_apply_catalog_discounts(
        ChannelPricingInterface $channelPricing,
        CatalogPromotionInterface $catalogPromotion,
        CatalogPromotionApplicatorInterface $catalogPromotionApplicator,
        ChannelInterface $channel,
        OrderInterface $order,
        OrderItemInterface $orderItem,
        ProductVariantInterface $promotionVariant,
        CatalogPromotionProviderInterface $catalogPromotionProvider,
        CatalogDiscountActionCommandInterface $actionCommand,
        ServiceRegistry $catalogActionRegistry
    ) {
        $promotionVariant->getChannelPricingForChannel($channel)->willReturn($channelPricing);
        $channelPricing->getPrice()->willReturn(1000);

        $catalogPromotionProvider->provide($channel, $promotionVariant)->willReturn([$catalogPromotion]);

        $catalogActionRegistry->get('action_discount')->willReturn($actionCommand);

        $catalogPromotion->getDiscountType()->willReturn('action_discount');
        $catalogPromotion->getDiscountConfiguration()->willReturn([]);
        $catalogPromotion->getName()->willReturn('Cool discount');

        $order->getItems()->willReturn([$orderItem]);
        $order->getChannel()->willReturn($channel);

        $orderItem->getVariant()->willReturn($promotionVariant);
        $orderItem->isImmutable()->willReturn(false);

        $actionCommand->calculate(1000, $channel, [])->willReturn(100);

        $catalogPromotionApplicator->apply($orderItem, 100, 'Cool discount')->shouldBeCalled();

        $this->process($order);
    }
}
