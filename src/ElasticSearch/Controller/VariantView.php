<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\ElasticSearch\Controller;

use Sylius\ElasticSearchPlugin\Controller\VariantView as BaseVariantView;

class VariantView extends BaseVariantView
{
    /**
     * @var AppliedPromotionView[]
     */
    public $appliedPromotions = [];
}
