<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class CatalogPromotionDiscountForEnabledChannel extends Constraint
{
    /**
     * @var string
     */
    public $message = 'urbanara_catalog_promotion.catalog_promotion.configuration.discounts.cannot_be_empty_for_enabled_channel';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return [self::CLASS_CONSTRAINT];
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'urbanara_catalog_promotion_discount_for_enabled_channel_validator';
    }
}
