<?php

namespace Acme\SyliusCatalogPromotionPlugin\Action;

use Sylius\Component\Core\Model\OrderItemInterface;

interface CatalogDiscountActionCommandInterface
{
    /**
     * @return string
     */
    public function getConfigurationFormType();

    /**
     * @param OrderItemInterface $orderItem
     * @param array $configuration
     *
     * @return int
     */
    public function calculate(OrderItemInterface $orderItem, array $configuration);
}
