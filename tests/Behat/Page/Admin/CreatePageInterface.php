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

    /**
     * @param \DateTime $dateTime
     */
    public function setStartsAt(\DateTime $dateTime);

    /**
     * @param \DateTime $dateTime
     */
    public function setEndsAt(\DateTime $dateTime);

    /**
     * @param string $type
     */
    public function chooseActionType($type);

    /**
     * @param string $field
     * @param float $amount
     */
    public function fillActionAmount($field, $amount);

    /**
     * @param string $channelName
     * @param string $option
     * @param string $value
     */
    public function fillActionForChannel($channelName, $option, $value);
}
