<?php

namespace Acme\SyliusCatalogPromotionPlugin\Provider;

use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ChannelInterface;

interface PreQualifiedCatalogPromotionProviderInterface
{
    /**
     * @param ChannelInterface $channel
     *
     * @return CatalogPromotionInterface[]|Collection
     */
    public function provide(ChannelInterface $channel);
}
