<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class CatalogPromotionDateRange extends Constraint
{
    /**
     * @var string
     */
    public $message = 'urbanara_catalog_promotion.catalog_promotion.end_date_cannot_be_set_prior_start_date';

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
        return 'urbanara_catalog_promotion_date_range_validator';
    }
}
