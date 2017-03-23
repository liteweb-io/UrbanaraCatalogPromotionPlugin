<?php

namespace Tests\Acme\SyliusCatalogPromotionPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\Acme\SyliusCatalogPromotionPlugin\Behat\Element\CatalogPromotionElementInterface;
use Webmozart\Assert\Assert;

final class CatalogPromotionContext implements Context
{
    /**
     * @var CatalogPromotionElementInterface
     */
    private $catalogPromotionElement;

    /**
     * @param CatalogPromotionElementInterface $catalogPromotionElement
     */
    public function __construct(CatalogPromotionElementInterface $catalogPromotionElement) {
        $this->catalogPromotionElement = $catalogPromotionElement;
    }

    /**
     * @Then the old product price :price should be crossed out
     */
    public function theOldProductPriceShouldBeCrossedOut($price)
    {
        Assert::same($this->catalogPromotionElement->getCrossedOutPrice(), $price);
    }

    /**
     * @Then the new product price should be :price
     */
    public function theNewProductPriceShouldBe($price)
    {
        Assert::same($this->catalogPromotionElement->getNewPrice(), $price);
    }
}
