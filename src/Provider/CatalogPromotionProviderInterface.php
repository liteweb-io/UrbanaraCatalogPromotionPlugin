<?php

namespace Urbanara\CatalogPromotionPlugin\Provider;

use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

interface CatalogPromotionProviderInterface
{
    /**
     * @param ChannelInterface $channel
     * @param ProductVariantInterface $productVariant
     *
     * @return CatalogPromotionInterface[]|Collection
     */
    public function provide(ChannelInterface $channel, ProductVariantInterface $productVariant);
}
