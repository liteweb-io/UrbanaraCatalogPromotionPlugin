<?php

namespace Tests\Acme\SyliusCatalogPromotionPlugin\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPageInterface;

interface IndexPageInterface extends BaseIndexPageInterface
{
    /**
     * @param string $promotionName
     *
     * @return bool
     */
    public function isExclusive($promotionName);

    /**
     * @param string $promotionCode
     *
     * @return string
     */
    public function getPriority($promotionCode);
}
