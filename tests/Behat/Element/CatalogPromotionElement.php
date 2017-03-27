<?php

namespace Tests\Urbanara\CatalogPromotionPlugin\Behat\Element;

final class CatalogPromotionElement extends Element implements CatalogPromotionElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCrossedOutPrice()
    {
        return $this->getDocument()->find('css', '.old-price')->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getNewPrice()
    {
        return $this->getDocument()->find('css', '.new-price')->getText();
    }
}
