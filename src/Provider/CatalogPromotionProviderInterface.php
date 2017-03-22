<?php

namespace Acme\SyliusCatalogPromotionPlugin\Provider;

use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

interface CatalogPromotionProviderInterface
{
    /**
     * @param ChannelInterface $channel
     * @param OrderItemInterface $orderItem
     *
     * @return CatalogPromotionInterface[]|Collection
     */
    public function provide(ChannelInterface $channel, OrderItemInterface $orderItem);
}
