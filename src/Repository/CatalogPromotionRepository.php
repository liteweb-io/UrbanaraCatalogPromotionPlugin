<?php

namespace Acme\SyliusCatalogPromotionPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

class CatalogPromotionRepository extends EntityRepository implements CatalogPromotionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findActiveForChannel(ChannelInterface $channel, \DateTime $date = null)
    {
        return $this->createQueryBuilder('o')
            ->where('o.startsAt IS NULL OR o.startsAt < :date')
            ->andWhere('o.endsAt IS NULL OR o.endsAt > :date')
            ->andWhere(':channel MEMBER OF o.channels')
            ->setParameter('channel', $channel)
            ->setParameter('date', $date ?: new \DateTime())
            ->getQuery()
            ->getResult()
        ;
    }
}