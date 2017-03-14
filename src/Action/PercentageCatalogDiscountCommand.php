<?php

namespace Acme\SyliusCatalogPromotionBundle\Action;

use Acme\SyliusCatalogPromotionBundle\Form\Type\Action\PercentageCatalogDiscountType;

final class PercentageCatalogDiscountCommand implements CatalogDiscountActionCommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return PercentageCatalogDiscountType::class;
    }
}
