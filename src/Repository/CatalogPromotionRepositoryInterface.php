<?php

namespace Acme\SyliusCatalogPromotionPlugin\Repository;

use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface CatalogPromotionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param ChannelInterface $channel
     * @param \DateTime|null $date
     *
     * @return CatalogPromotionInterface[]|Collection
     */
    public function findActiveForChannel(ChannelInterface $channel, \DateTime $date = null);
}