<?php

namespace spec\Acme\SyliusCatalogPromotionBundle\Action;

use Acme\SyliusCatalogPromotionBundle\Action\CatalogDiscountActionCommandInterface;
use Acme\SyliusCatalogPromotionBundle\Action\FixedCatalogDiscountCommand;
use Acme\SyliusCatalogPromotionBundle\Form\Type\Action\FixedCatalogDiscountType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

final class FixedCatalogDiscountCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FixedCatalogDiscountCommand::class);
    }

    function it_is_catalog_discount_action_command()
    {
        $this->shouldImplement(CatalogDiscountActionCommandInterface::class);
    }

    function it_provides_related_configuration_type()
    {
        $this->getConfigurationFormType()->shouldReturn(FixedCatalogDiscountType::class);
    }

    function it_applies_discount_to_order_item(
        OrderItemInterface $orderItem,
        OrderInterface $order,
        ChannelInterface $channel
    ) {
        $orderItem->getUnitPrice()->willReturn(1000);
        $orderItem->getOrder()->willReturn($order);
        $order->getChannel()->willReturn($channel);
        $channel->getCode()->willReturn('WEB-US');

        $this->calculate($orderItem, ['values' => ['WEB-US' => 100]])->shouldReturn(100);
    }

    function it_applies_discount_to_order_item_not_bigger_then_cost_of_item(
        OrderItemInterface $orderItem,
        OrderInterface $order,
        ChannelInterface $channel
    ) {
        $orderItem->getUnitPrice()->willReturn(100);
        $orderItem->getOrder()->willReturn($order);
        $order->getChannel()->willReturn($channel);
        $channel->getCode()->willReturn('WEB-US');

        $this->calculate($orderItem, ['values' => ['WEB-US' => 1000]])->shouldReturn(100);
    }

    function it_throws_an_exception_if_configuration_is_not_valid(
        OrderItemInterface $orderItem,
        OrderInterface $order,
        ChannelInterface $channel
    ) {
        $orderItem->getOrder()->willReturn($order);
        $order->getChannel()->willReturn($channel);
        $channel->getCode()->willReturn('WEB-US');

        $this->shouldThrow(new \InvalidArgumentException('The promotion has not been configured for requested channel.'))->during('calculate', [$orderItem, [], '']);
        $this->shouldThrow(new \InvalidArgumentException('The promotion has not been configured for requested channel.'))->during('calculate', [$orderItem, ['values' => []], '']);
        $this->shouldThrow(new \InvalidArgumentException('The promotion has not been configured for requested channel.'))->during('calculate', [$orderItem, ['values' => ['WEB-US' => 'sadsa']], '']);
    }
}
