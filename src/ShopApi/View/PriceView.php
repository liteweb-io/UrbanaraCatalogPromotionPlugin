<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\ShopApi\View;

use Sylius\ShopApiPlugin\View\PriceView as BasePriceView;

class PriceView extends BasePriceView
{
    /** @var int */
    public $original;
}
