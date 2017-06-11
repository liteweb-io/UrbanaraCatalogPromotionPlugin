<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\ElasticSearch\Controller;

use Sylius\ElasticSearchPlugin\Controller\PriceView as BasePriceView;

class PriceView extends BasePriceView
{
    /** @var int */
    public $original;
}
