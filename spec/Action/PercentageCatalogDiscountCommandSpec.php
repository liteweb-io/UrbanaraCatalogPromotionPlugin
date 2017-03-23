<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\Action;

use Acme\SyliusCatalogPromotionPlugin\Action\CatalogDiscountActionCommandInterface;
use Acme\SyliusCatalogPromotionPlugin\Action\PercentageCatalogDiscountCommand;
use Acme\SyliusCatalogPromotionPlugin\Form\Type\Action\PercentageCatalogDiscountType;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

final class PercentageCatalogDiscountCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PercentageCatalogDiscountCommand::class);
    }

    function it_is_catalog_discount_action_command()
    {
        $this->shouldImplement(CatalogDiscountActionCommandInterface::class);
    }

    function it_provides_related_configuration_type()
    {
        $this->getConfigurationFormType()->shouldReturn(PercentageCatalogDiscountType::class);
    }

    function it_applies_percentage_discount_to_order_item(ChannelInterface $channel) {
        $this->calculate(1000, $channel, ['percentage' => 0.1])->shouldReturn(100);
    }

    function it_throws_an_exception_if_configuration_is_not_valid(ChannelInterface $channel) {
        $this->shouldThrow(new \InvalidArgumentException('Current price is not an integer.'))->during('calculate',  ['1000', $channel, []]);
        $this->shouldThrow(new \InvalidArgumentException('"percentage" must be set and must be a float.'))->during('calculate',  [1000, $channel, []]);
        $this->shouldThrow(new \InvalidArgumentException('"percentage" must be set and must be a float.'))->during('calculate',  [1000, $channel, ['percentage' => '0.1']]);
    }
}
