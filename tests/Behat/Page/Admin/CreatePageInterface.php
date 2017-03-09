<?php

namespace Tests\Acme\SyliusCatalogPromotionBundle\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;

interface CreatePageInterface extends BaseCreatePageInterface
{
    /**
     * @param string $name
     */
    public function nameIt($name);

    /**
     * @param string $code
     */
    public function specifyCode($code);

    public function makeExclusive();
}
