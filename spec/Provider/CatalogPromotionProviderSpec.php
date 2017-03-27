<?php

namespace spec\Urbanara\CatalogPromotionPlugin\Provider;

use Urbanara\CatalogPromotionPlugin\Checker\EligibilityCheckerInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\Provider\CatalogPromotionProvider;
use Urbanara\CatalogPromotionPlugin\Provider\CatalogPromotionProviderInterface;
use Urbanara\CatalogPromotionPlugin\Repository\CatalogPromotionRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class CatalogPromotionProviderSpec extends ObjectBehavior
{
    function let(CatalogPromotionRepositoryInterface $catalogPromotionRepository, EligibilityCheckerInterface $checker)
    {
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
        ProductVariantInterface $productVariant
    ) {
        $catalogPromotionRepository->findActiveForChannel($channel)->willReturn([$catalogPromotion1, $catalogPromotion2]);
        $catalogPromotion1->isExclusive()->willReturn(false);
        $catalogPromotion2->isExclusive()->willReturn(false);

        $checker->isEligible($productVariant, $catalogPromotion1)->willReturn(true);
        $checker->isEligible($productVariant, $catalogPromotion2)->willReturn(true);

        $this->provide($channel, $productVariant)->shouldReturn([$catalogPromotion1, $catalogPromotion2]);
    }

    function it_provides_only_one_exclusive_promotion(
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        CatalogPromotionInterface $normalCatalogPromotion,
        CatalogPromotionInterface $prioritizedExclusiveCatalogPromotion,
        CatalogPromotionInterface $regularExclusiveCatalogPromotion,
        ChannelInterface $channel,
        EligibilityCheckerInterface $checker,
        ProductVariantInterface $productVariant
    ) {
        $catalogPromotionRepository->findActiveForChannel($channel)->willReturn([
            $normalCatalogPromotion,
            $prioritizedExclusiveCatalogPromotion,
            $regularExclusiveCatalogPromotion
        ]);

        $normalCatalogPromotion->isExclusive()->willReturn(false);
        $prioritizedExclusiveCatalogPromotion->isExclusive()->willReturn(true);
        $regularExclusiveCatalogPromotion->isExclusive()->willReturn(true);

        $checker->isEligible($productVariant, $normalCatalogPromotion)->willReturn(true);
        $checker->isEligible($productVariant, $prioritizedExclusiveCatalogPromotion)->willReturn(true);
        $checker->isEligible($productVariant, $regularExclusiveCatalogPromotion)->willReturn(true);

        $this->provide($channel, $productVariant)->shouldReturn([$prioritizedExclusiveCatalogPromotion]);
    }

    function it_provides_only_eligiable_promotions(
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        CatalogPromotionInterface $catalogPromotion,
        CatalogPromotionInterface $eligiblePromotion,
        CatalogPromotionInterface $exclusiveCatalogPromotion,
        ChannelInterface $channel,
        EligibilityCheckerInterface $checker,
        ProductVariantInterface $productVariant
    ) {
        $catalogPromotionRepository->findActiveForChannel($channel)->willReturn([$catalogPromotion, $eligiblePromotion, $exclusiveCatalogPromotion]);
        $catalogPromotion->isExclusive()->willReturn(false);
        $eligiblePromotion->isExclusive()->willReturn(false);
        $exclusiveCatalogPromotion->isExclusive()->willReturn(true);

        $checker->isEligible($productVariant, $catalogPromotion)->willReturn(false);
        $checker->isEligible($productVariant, $eligiblePromotion)->willReturn(true);
        $checker->isEligible($productVariant, $exclusiveCatalogPromotion)->willReturn(false);

        $this->provide($channel, $productVariant)->shouldReturn([$eligiblePromotion]);
    }
}
