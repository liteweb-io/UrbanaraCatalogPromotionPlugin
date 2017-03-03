<?php

namespace Tests\Acme\SyliusCatalogPromotionBundle\Behat\Page\Shop;

use Sylius\Behat\Page\PageInterface;

interface WelcomePageInterface extends PageInterface
{
    /**
     * @return string
     */
    public function getGreeting();
}
