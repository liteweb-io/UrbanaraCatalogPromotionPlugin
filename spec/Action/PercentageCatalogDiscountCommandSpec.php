<?php

namespace spec\Acme\SyliusCatalogPromotionBundle\Action;

use Acme\SyliusCatalogPromotionBundle\Action\CatalogDiscountActionCommandInterface;
use Acme\SyliusCatalogPromotionBundle\Action\PercentageCatalogDiscountCommand;
use Acme\SyliusCatalogPromotionBundle\Form\Type\Action\PercentageCatalogDiscountType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PercentageCatalogDiscountCommandSpec extends ObjectBehavior
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
}
