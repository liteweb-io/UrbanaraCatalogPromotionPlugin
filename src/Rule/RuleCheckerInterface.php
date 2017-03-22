<?php

namespace Acme\SyliusCatalogPromotionPlugin\Rule;

use Sylius\Component\Core\Model\OrderItemInterface;

interface RuleCheckerInterface
{
    /**
     * @return string
     */
    public function getConfigurationFormType();

    /**
     * @param OrderItemInterface $orderItem
     * @param array $configuration
     *
     * @return bool
     */
    public function isEligible(OrderItemInterface $orderItem, array $configuration);
}
