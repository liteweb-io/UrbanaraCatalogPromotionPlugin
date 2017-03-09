<?php

namespace Tests\Acme\SyliusCatalogPromotionBundle\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface
{
    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    public function hasStartsAt(\DateTime $dateTime);

    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    public function hasEndsAt(\DateTime $dateTime);
}