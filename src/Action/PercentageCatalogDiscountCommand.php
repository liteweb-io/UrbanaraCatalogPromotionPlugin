<?php

namespace Acme\SyliusCatalogPromotionPlugin\Action;

use Acme\SyliusCatalogPromotionPlugin\Form\Type\Action\PercentageCatalogDiscountType;
use Sylius\Component\Core\Model\OrderItemInterface;

final class PercentageCatalogDiscountCommand implements CatalogDiscountActionCommandInterface
{
    const TYPE = 'percentage_discount';

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return PercentageCatalogDiscountType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(OrderItemInterface $orderItem, array $configuration)
    {
        $this->isConfigurationValid($configuration);

        $promotionDiscount = $configuration['percentage'];
        $currentPrice = $orderItem->getUnitPrice();

        return (int) ($currentPrice * $promotionDiscount);
    }

    /**
     * @param array $configuration
     *
     * @throws \InvalidArgumentException
     */
    private function isConfigurationValid(array $configuration)
    {
        if (!isset($configuration['percentage']) || !is_float($configuration['percentage'])) {
            throw new \InvalidArgumentException('"percentage" must be set and must be a float.');
        }
    }
}
