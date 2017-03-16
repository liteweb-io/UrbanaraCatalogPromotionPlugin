<?php

namespace Acme\SyliusCatalogPromotionBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class CatalogPromotionDateRange extends Constraint
{
    /**
     * @var string
     */
    public $message = 'acme_sylius_catalog_promotion.catalog_promotion.end_date_cannot_be_set_prior_start_date';

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
        return 'acme_sylius_catalog_promotion_date_range_validator';
    }
}
