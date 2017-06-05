<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Action;

use Urbanara\CatalogPromotionPlugin\Form\Type\Action\FixedCatalogDiscountType;
use Sylius\Component\Core\Model\ChannelInterface;
use Webmozart\Assert\Assert;

final class FixedCatalogDiscountCommand implements CatalogDiscountActionCommandInterface
{
    const TYPE = 'fixed_discount';

    public function getConfigurationFormType()
    {
        return FixedCatalogDiscountType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate($currentPrice, ChannelInterface $channel, array $configuration)
    {
        Assert::integer($currentPrice, 'Current price is not an integer.');

        $channelCode = $channel->getCode();
        $this->isConfigurationValid($configuration, $channelCode);

        $promotionDiscount = $configuration['values'][$channelCode];

        return min($currentPrice, $promotionDiscount);
    }

    /**
     * @param array $configuration
     * @param string $channel
     */
    private function isConfigurationValid(array $configuration, $channel)
    {
        Assert::keyExists($configuration, 'values', 'The promotion has not been configured for requested channel.');
        Assert::keyExists($configuration['values'], $channel, 'The promotion has not been configured for requested channel.');
        Assert::integer($configuration['values'][$channel], 'The promotion has not been configured for requested channel.');
    }
}
