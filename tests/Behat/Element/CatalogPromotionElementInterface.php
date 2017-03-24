<?php

namespace Tests\Acme\SyliusCatalogPromotionPlugin\Behat\Element;

interface CatalogPromotionElementInterface
{
    /**
     * @return string
     */
    public function getCrossedOutPrice();

    /**
     * @return string
     */
    public function getNewPrice();
}
