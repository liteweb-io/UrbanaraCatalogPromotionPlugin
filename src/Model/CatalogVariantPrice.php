<?php

namespace Urbanara\CatalogPromotionPlugin\Model;

final class CatalogVariantPrice
{
    /**
     * @var int
     */
    private $basePrice;

    /**
     * @var int
     */
    private $currentPrice;

    /**
     * @param int $basePrice
     * @param int $currentPrice
     */
    public function __construct($basePrice, $currentPrice)
    {
        $this->basePrice = $basePrice;
        $this->currentPrice = $currentPrice;
    }

    /**
     * @return int
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * @return int
     */
    public function getCurrentPrice()
    {
        return $this->currentPrice;
    }
}
