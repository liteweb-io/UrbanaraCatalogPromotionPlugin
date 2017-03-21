<?php

namespace Acme\SyliusCatalogPromotionPlugin\Provider;

use Acme\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;

final class PreQualifiedCatalogPromotionProvider implements PreQualifiedCatalogPromotionProviderInterface
{
    /**
     * @var CatalogPromotionRepositoryInterface
     */
    private $catalogPromotionRepository;

    /**
     * @param CatalogPromotionRepositoryInterface $catalogPromotionRepository
     */
    public function __construct(CatalogPromotionRepositoryInterface $catalogPromotionRepository) {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function provide(ChannelInterface $channel)
    {
        $catalogPromotions = $this->catalogPromotionRepository->findActiveForChannel($channel);

        foreach ($catalogPromotions as $catalogPromotion) {
            if ($catalogPromotion->isExclusive()) {
                return [$catalogPromotion];
            }
        }

        return $catalogPromotions;
    }
}
