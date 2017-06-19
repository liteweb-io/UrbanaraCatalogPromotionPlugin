<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\ElasticSearch\Controller;

class AppliedPromotionView
{
    /**
     * @var string
     */
    public $code;

    /**
     * @var DecorationView[]
     */
    public $decorations = [];
}
