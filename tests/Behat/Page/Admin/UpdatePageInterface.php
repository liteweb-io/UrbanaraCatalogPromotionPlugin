<?php

namespace Tests\Urbanara\CatalogPromotionPlugin\Behat\Page\Admin;

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

    /**
     * @return string
     */
    public function getAmount();

    /**
     * @param string $channelCode
     */
    public function getValueForChannel($channelCode);

    /**
     * @param string $channelName
     *
     * @return bool
     */
    public function checkChannelsState($channelName);

    /**
     * @return bool
     */
    public function isCodeDisabled();

    /**
     * @param string $criteria
     * @param int    $numWeeks
     *
     * @return bool
     */
    public function hasMatchingDeliveryTimeRule(string $criteria, int $numWeeks) : bool;
}
