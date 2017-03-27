<?php

namespace Urbanara\CatalogPromotionPlugin\Action;

use Sylius\Component\Core\Model\ChannelInterface;

interface CatalogDiscountActionCommandInterface
{
    /**
     * @return string
     */
    public function getConfigurationFormType();

    /**
     * @param int $currentPrice
     * @param ChannelInterface $channel
     * @param array $configuration
     *
     * @return int
     */
    public function calculate($currentPrice, ChannelInterface $channel, array $configuration);
}
