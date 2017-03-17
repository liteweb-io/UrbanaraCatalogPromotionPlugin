<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\OrderProcessing;

use Acme\SyliusCatalogPromotionPlugin\Action\CatalogDiscountActionCommandInterface;
use Acme\SyliusCatalogPromotionPlugin\Applicator\CatalogPromotionApplicatorInterface;
use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Acme\SyliusCatalogPromotionPlugin\OrderProcessing\CatalogPromotionProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Registry\ServiceRegistry;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class CatalogPromotionProcessorSpec extends ObjectBehavior
{
    function let(
        RepositoryInterface $catalogPromotionRepository,
        ServiceRegistry $catalogActionRegistry,
        CatalogPromotionApplicatorInterface $catalogPromotionApplicator
    ) {
        $this->beConstructedWith($catalogPromotionRepository, $catalogActionRegistry, $catalogPromotionApplicator);
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
        CatalogPromotionInterface $catalogPromotion,
        CatalogPromotionApplicatorInterface $catalogPromotionApplicator,
        OrderInterface $order,
        OrderItemInterface $orderItem,
        RepositoryInterface $catalogPromotionRepository,
        CatalogDiscountActionCommandInterface $actionCommand,
        ServiceRegistry $catalogActionRegistry
    ) {
        $catalogPromotionRepository->findAll()->willReturn([$catalogPromotion]);

        $catalogActionRegistry->get('action_discount')->willReturn($actionCommand);

        $catalogPromotion->getType()->willReturn('action_discount');
        $catalogPromotion->getConfiguration()->willReturn([]);
        $catalogPromotion->getName()->willReturn('Cool discount');

        $order->getItems()->willReturn([$orderItem]);
        $orderItem->isImmutable()->willReturn(false);

        $actionCommand->calculate($orderItem, [])->willReturn(100);

        $catalogPromotionApplicator->apply($orderItem, 100, 'Cool discount')->shouldBeCalled();

        $this->process($order);
    }
}
