<?php

namespace Acme\SyliusCatalogPromotionBundle\Action;

use Acme\SyliusCatalogPromotionBundle\Form\Type\Action\FixedCatalogDiscountType;

final class FixedCatalogDiscountCommand implements CatalogDiscountActionCommandInterface
{
    const TYPE = 'fixed_discount';

    public function getConfigurationFormType()
    {
        return FixedCatalogDiscountType::class;
    }
}
