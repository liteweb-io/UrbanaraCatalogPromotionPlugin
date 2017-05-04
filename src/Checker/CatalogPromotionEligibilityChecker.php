<?php

namespace Urbanara\CatalogPromotionPlugin\Checker;

use Psr\Log\LoggerInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\Exception\CatalogPromotionRuleException;
use Urbanara\CatalogPromotionPlugin\Rule\RuleCheckerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class CatalogPromotionEligibilityChecker implements EligibilityCheckerInterface
{
    /**
     * @var ServiceRegistryInterface
     */
    private $registry;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ServiceRegistryInterface $registry
     * @param LoggerInterface $logger
     */
    public function __construct(ServiceRegistryInterface $registry, LoggerInterface $logger)
    {
        $this->registry = $registry;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function isEligible(ProductVariantInterface $productVariant, CatalogPromotionInterface $catalogPromotion)
    {
        foreach ($catalogPromotion->getRules() as $rule) {
            /** @var RuleCheckerInterface $ruleChecker */
            $ruleChecker = $this->registry->get($rule->getType());
            try {
                if (!$ruleChecker->isEligible($productVariant, $rule->getConfiguration())) {
                    return false;
                }
            } catch (CatalogPromotionRuleException $ex) {
                $this->logger->error(
                    sprintf('CatalogPromotionRuleException: %s', $ex->getMessage()),
                    [
                        'Component' => self::class,
                        'RuleId' => $rule->getId(),
                        'ProductId' => $productVariant->getProduct()->getId()
                    ]
                );
                continue;
            }
        }

        return true;
    }
}
