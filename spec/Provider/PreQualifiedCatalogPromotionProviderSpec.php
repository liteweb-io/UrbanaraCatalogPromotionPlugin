<?php

namespace spec\Acme\SyliusCatalogPromotionPlugin\Provider;

use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Acme\SyliusCatalogPromotionPlugin\Provider\PrequalifiedCatalogPromotionProvider;
use Acme\SyliusCatalogPromotionPlugin\Provider\PreQualifiedCatalogPromotionProviderInterface;
use Acme\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ChannelInterface;

class PreQualifiedCatalogPromotionProviderSpec extends ObjectBehavior
{
    function let(CatalogPromotionRepositoryInterface $catalogPromotionRepository) {
        $this->beConstructedWith($catalogPromotionRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PrequalifiedCatalogPromotionProvider::class);
    }

    function it_is_provider()
    {
        $this->shouldImplement(PreQualifiedCatalogPromotionProviderInterface::class);
    }

    function it_provides_all_catalog_promotions_if_non_of_them_is_exclusive(
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        CatalogPromotionInterface $catalogPromotion1,
        CatalogPromotionInterface $catalogPromotion2,
        ChannelInterface $channel
    ) {
        $catalogPromotionRepository->findActiveForChannel($channel)->willReturn([$catalogPromotion1, $catalogPromotion2]);
        $catalogPromotion1->isExclusive()->willReturn(false);
        $catalogPromotion2->isExclusive()->willReturn(false);

        $this->provide($channel)->shouldReturn([$catalogPromotion1, $catalogPromotion2]);
    }

    function it_provides_only_one_exclusive_promotion(
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        CatalogPromotionInterface $normalCatalogPromotion,
        CatalogPromotionInterface $exclusiveCatalogPromotion,
        ChannelInterface $channel
    ) {
        $catalogPromotionRepository->findActiveForChannel($channel)->willReturn([$normalCatalogPromotion, $exclusiveCatalogPromotion]);
        $normalCatalogPromotion->isExclusive()->willReturn(false);
        $exclusiveCatalogPromotion->isExclusive()->willReturn(true);

        $this->provide($channel)->shouldReturn([$exclusiveCatalogPromotion]);
    }
}
