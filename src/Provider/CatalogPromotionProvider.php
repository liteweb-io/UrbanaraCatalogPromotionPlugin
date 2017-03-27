<?php

namespace Urbanara\CatalogPromotionPlugin\Provider;

use Urbanara\CatalogPromotionPlugin\Checker\EligibilityCheckerInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\Repository\CatalogPromotionRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class CatalogPromotionProvider implements CatalogPromotionProviderInterface
{
    /**
     * @var CatalogPromotionRepositoryInterface
     */
    private $catalogPromotionRepository;

    /**
     * @var EligibilityCheckerInterface
     */
    private $checker;

    /**
     * @param CatalogPromotionRepositoryInterface $catalogPromotionRepository
     * @param EligibilityCheckerInterface $checker
     */
    public function __construct(
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        EligibilityCheckerInterface $checker
    ) {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
        $this->checker = $checker;
    }

    /**
     * {@inheritdoc}
     */
    public function provide(ChannelInterface $channel, ProductVariantInterface $productVariant)
    {
        $catalogPromotions = $this->catalogPromotionRepository->findActiveForChannel($channel);

        $eligiblePromotions = array_filter($catalogPromotions, function (CatalogPromotionInterface $catalogPromotion) use ($productVariant) {
            return $this->checker->isEligible($productVariant, $catalogPromotion);
        });

        /** @var CatalogPromotionInterface $catalogPromotion */
        foreach ($eligiblePromotions as $catalogPromotion) {
            if ($catalogPromotion->isExclusive()) {
                return [$catalogPromotion];
            }
        }

        return array_values($eligiblePromotions);
    }
}
