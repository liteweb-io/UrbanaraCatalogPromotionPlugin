<?php

namespace Acme\SyliusCatalogPromotionBundle\Action;

use Acme\SyliusCatalogPromotionBundle\Form\Type\Action\PercentageCatalogDiscountType;

final class PercentageCatalogDiscountCommand implements CatalogDiscountActionCommandInterface
{
    const TYPE = 'catalog_promotion_percentage_discount';

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return PercentageCatalogDiscountType::class;
    }
}
