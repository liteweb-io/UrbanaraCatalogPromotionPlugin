<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\Provider;

use Acme\SyliusCatalogPromotionPlugin\Checker\EligibilityCheckerInterface;
use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Acme\SyliusCatalogPromotionPlugin\Provider\CatalogPromotionProvider;
use Acme\SyliusCatalogPromotionPlugin\Provider\CatalogPromotionProviderInterface;
use Acme\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

final class CatalogPromotionProviderSpec extends ObjectBehavior
{
    function let(CatalogPromotionRepositoryInterface $catalogPromotionRepository, EligibilityCheckerInterface $checker) {
        $this->beConstructedWith($catalogPromotionRepository, $checker);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CatalogPromotionProvider::class);
    }

    function it_is_provider()
    {
        $this->shouldImplement(CatalogPromotionProviderInterface::class);
    }

    function it_provides_all_catalog_promotions_if_non_of_them_is_exclusive(
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        CatalogPromotionInterface $catalogPromotion1,
        CatalogPromotionInterface $catalogPromotion2,
        ChannelInterface $channel,
        EligibilityCheckerInterface $checker,
        OrderItemInterface $orderItem
    ) {
        $catalogPromotionRepository->findActiveForChannel($channel)->willReturn([$catalogPromotion1, $catalogPromotion2]);
        $catalogPromotion1->isExclusive()->willReturn(false);
        $catalogPromotion2->isExclusive()->willReturn(false);

        $checker->isEligible($orderItem, $catalogPromotion1)->willReturn(true);
        $checker->isEligible($orderItem, $catalogPromotion2)->willReturn(true);

        $this->provide($channel, $orderItem)->shouldReturn([$catalogPromotion1, $catalogPromotion2]);
    }

    function it_provides_only_one_exclusive_promotion(
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        CatalogPromotionInterface $normalCatalogPromotion,
        CatalogPromotionInterface $exclusiveCatalogPromotion,
        ChannelInterface $channel,
        EligibilityCheckerInterface $checker,
        OrderItemInterface $orderItem
    ) {
        $catalogPromotionRepository->findActiveForChannel($channel)->willReturn([$normalCatalogPromotion, $exclusiveCatalogPromotion]);
        $normalCatalogPromotion->isExclusive()->willReturn(false);
        $exclusiveCatalogPromotion->isExclusive()->willReturn(true);

        $checker->isEligible($orderItem, $normalCatalogPromotion)->willReturn(true);
        $checker->isEligible($orderItem, $exclusiveCatalogPromotion)->willReturn(true);

        $this->provide($channel, $orderItem)->shouldReturn([$exclusiveCatalogPromotion]);
    }

    function it_provides_only_eligiable_promotions(
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        CatalogPromotionInterface $catalogPromotion,
        CatalogPromotionInterface $eligiblePromotion,
        CatalogPromotionInterface $exclusiveCatalogPromotion,
        ChannelInterface $channel,
        EligibilityCheckerInterface $checker,
        OrderItemInterface $orderItem
    ) {
        $catalogPromotionRepository->findActiveForChannel($channel)->willReturn([$catalogPromotion, $eligiblePromotion, $exclusiveCatalogPromotion]);
        $catalogPromotion->isExclusive()->willReturn(false);
        $eligiblePromotion->isExclusive()->willReturn(false);
        $exclusiveCatalogPromotion->isExclusive()->willReturn(true);

        $checker->isEligible($orderItem, $catalogPromotion)->willReturn(false);
        $checker->isEligible($orderItem, $eligiblePromotion)->willReturn(true);
        $checker->isEligible($orderItem, $exclusiveCatalogPromotion)->willReturn(false);

        $this->provide($channel, $orderItem)->shouldReturn([$eligiblePromotion]);
    }
}
