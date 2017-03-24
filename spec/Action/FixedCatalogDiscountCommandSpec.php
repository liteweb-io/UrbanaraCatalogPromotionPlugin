<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\Action;

use Acme\SyliusCatalogPromotionPlugin\Action\CatalogDiscountActionCommandInterface;
use Acme\SyliusCatalogPromotionPlugin\Action\FixedCatalogDiscountCommand;
use Acme\SyliusCatalogPromotionPlugin\Form\Type\Action\FixedCatalogDiscountType;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;

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
        ChannelInterface $channel
    ) {
        $channel->getCode()->willReturn('WEB-US');

        $this->calculate(1000, $channel, ['values' => ['WEB-US' => 100]])->shouldReturn(100);
    }

    function it_applies_discount_to_order_item_not_bigger_then_cost_of_item(
        ChannelInterface $channel
    ) {
        $channel->getCode()->willReturn('WEB-US');

        $this->calculate(100, $channel, ['values' => ['WEB-US' => 1000]])->shouldReturn(100);
    }

    function it_throws_an_exception_if_configuration_is_not_valid(
        ChannelInterface $channel
    ) {
        $channel->getCode()->willReturn('WEB-US');

        $this->shouldThrow(new \InvalidArgumentException('Current price is not an integer.'))->during('calculate', ['1000', $channel, [], '']);
        $this->shouldThrow(new \InvalidArgumentException('The promotion has not been configured for requested channel.'))->during('calculate', [1000, $channel, [], '']);
        $this->shouldThrow(new \InvalidArgumentException('The promotion has not been configured for requested channel.'))->during('calculate', [1000, $channel, ['values' => []], '']);
        $this->shouldThrow(new \InvalidArgumentException('The promotion has not been configured for requested channel.'))->during('calculate', [1000, $channel, ['values' => ['WEB-US' => 'sadsa']], '']);
    }
}
