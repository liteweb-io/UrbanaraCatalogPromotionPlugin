<?php

namespace Acme\SyliusCatalogPromotionPlugin\Checker;

use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Acme\SyliusCatalogPromotionPlugin\Rule\RuleCheckerInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class CatalogPromotionEligibilityChecker implements EligibilityCheckerInterface
{
    /**
     * @var ServiceRegistryInterface
     */
    private $registry;

    /**
     * @param ServiceRegistryInterface $registry
     */
    public function __construct(ServiceRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function isEligible(OrderItemInterface $orderItem, CatalogPromotionInterface $catalogPromotion)
    {
        foreach ($catalogPromotion->getRules() as $rule) {
            /** @var RuleCheckerInterface $ruleChecker */
            $ruleChecker = $this->registry->get($rule->getType());

            if (!$ruleChecker->isEligible($orderItem, $rule->getConfiguration())) {
                return false;
            }
        }

        return true;
    }
}
