<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\Templating\Helper;

use Acme\SyliusCatalogPromotionPlugin\Action\CatalogDiscountActionCommandInterface;
use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Acme\SyliusCatalogPromotionPlugin\Model\CatalogVariantPrice;
use Acme\SyliusCatalogPromotionPlugin\Provider\CatalogPromotionProviderInterface;
use Acme\SyliusCatalogPromotionPlugin\Templating\Helper\CatalogPriceHelper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\Templating\Helper\Helper;

final class CatalogPriceHelperSpec extends ObjectBehavior
{
    function let(ServiceRegistryInterface $registry, CatalogPromotionProviderInterface $provider)
    {
        $this->beConstructedWith($provider, $registry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CatalogPriceHelper::class);
    }

    function it_is_a_twig_helper()
    {
        $this->shouldHaveType(Helper::class);
    }

    function it_calculates_catalog_price_for_product_variant(
        ChannelInterface $channel,
        ChannelPricingInterface $channelPricing,
        CatalogPromotionInterface $catalogPromotion,
        CatalogPromotionInterface $anotherCatalogPromotion,
        ServiceRegistryInterface $registry,
        CatalogDiscountActionCommandInterface $someActionCommand,
        CatalogDiscountActionCommandInterface $anotherActionCommand,
        ProductVariantInterface $productVariant,
        CatalogPromotionProviderInterface $provider
    ) {
        $productVariant->getChannelPricingForChannel($channel)->willReturn($channelPricing);
        $channelPricing->getPrice()->willReturn(1000);

        $provider->provide($channel, $productVariant)->willReturn([$catalogPromotion, $anotherCatalogPromotion]);

        $catalogPromotion->getDiscountType()->willReturn('some_discount_identifier');
        $catalogPromotion->getDiscountConfiguration()->willReturn([]);

        $anotherCatalogPromotion->getDiscountType()->willReturn('another_discount_identifier');
        $anotherCatalogPromotion->getDiscountConfiguration()->willReturn([]);

        $registry->get('some_discount_identifier')->willReturn($someActionCommand);
        $registry->get('another_discount_identifier')->willReturn($anotherActionCommand);

        $someActionCommand->calculate(1000, $channel, [])->willReturn(100);
        $anotherActionCommand->calculate(900, $channel, [])->willReturn(200);

        $this->getCatalogPrice($productVariant, ['channel' => $channel])->shouldBeLike(new CatalogVariantPrice(1000, 700));
    }
}
