<?php

namespace Acme\SyliusCatalogPromotionPlugin\Rule;

use Acme\SyliusCatalogPromotionPlugin\Form\Type\Rule\IsProductType;

final class IsProductRuleChecker implements RuleCheckerInterface
{
    public function getConfigurationFormType()
    {
        return IsProductType::class;
    }
}
