<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\ShopApi\View;

use Sylius\ShopApiPlugin\View\ProductVariantView as BaseProductVariantView;

class ProductVariantView extends BaseProductVariantView
{
    /** @var AppliedPromotionView[] */
    public $appliedPromotions = [];
}
