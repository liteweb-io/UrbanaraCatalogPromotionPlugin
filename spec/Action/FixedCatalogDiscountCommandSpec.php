<?php

namespace spec\Acme\SyliusCatalogPromotionBundle\Action;

use Acme\SyliusCatalogPromotionBundle\Action\CatalogDiscountActionCommandInterface;
use Acme\SyliusCatalogPromotionBundle\Action\FixedCatalogDiscountCommand;
use Acme\SyliusCatalogPromotionBundle\Form\Type\Action\FixedCatalogDiscountType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
}
