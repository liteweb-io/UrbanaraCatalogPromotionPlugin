<?php

namespace Acme\SyliusCatalogPromotionPlugin\Rule;

use Acme\SyliusCatalogPromotionPlugin\Form\Type\Rule\IsProductType;
use Sylius\Component\Core\Model\OrderItemInterface;

final class IsProductRuleChecker implements RuleCheckerInterface
{
    const TYPE = 'is_product';

    public function getConfigurationFormType()
    {
        return IsProductType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function isEligible(OrderItemInterface $orderItem, array $configuration)
    {
        return in_array($orderItem->getProduct()->getCode(), $configuration['products'], true);
    }
}
