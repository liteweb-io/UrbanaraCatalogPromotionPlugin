<?php

namespace Acme\SyliusCatalogPromotionPlugin\Action;

use Acme\SyliusCatalogPromotionPlugin\Form\Type\Action\FixedCatalogDiscountType;
use Sylius\Component\Core\Model\OrderItemInterface;

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
    public function calculate(OrderItemInterface $orderItem, array $configuration)
    {
        $channelCode = $orderItem->getOrder()->getChannel()->getCode();

        $this->isConfigurationValid($configuration, $channelCode);

        $promotionDiscount = $configuration['values'][$channelCode];
        $currentPrice = $orderItem->getUnitPrice();

        return $promotionDiscount > $currentPrice ? $currentPrice : $promotionDiscount;
    }

    /**
     * @param array $configuration
     *
     * @throws \InvalidArgumentException
     */
    private function isConfigurationValid(array $configuration, $channel)
    {
        if (!isset($configuration['values'], $configuration['values'][$channel]) || !is_int($configuration['values'][$channel])) {
            throw new \InvalidArgumentException('The promotion has not been configured for requested channel.');
        }
    }
}
