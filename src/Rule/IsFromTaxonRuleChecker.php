<?php

namespace Acme\SyliusCatalogPromotionPlugin\Rule;

use Acme\SyliusCatalogPromotionPlugin\Form\Type\Rule\IsFromTaxonType;

final class IsFromTaxonRuleChecker implements RuleCheckerInterface
{
    public function getConfigurationFormType()
    {
        return IsFromTaxonType::class;
    }
}
