<?php

declare(strict_types=1);

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

    /**
     * @param string $sku
     *
     * @return bool
     */
    public function hasMatchingIsProductSkuRule(string $sku) : bool;

    /**
     * @param bool $activeOnProductDisplayPage
     * @param bool $activeOnProductListingPage
     * @param bool $activeOnCheckoutPage
     *
     * @return bool
     */
    public function hasStrikethroughDecoration(bool $activeOnProductDisplayPage, bool $activeOnProductListingPage, bool $activeOnCheckoutPage): bool;

    /**
     * @param string $message
     * @param bool $activeOnProductDisplayPage
     * @param bool $activeOnProductListingPage
     * @param bool $activeOnCheckoutPage
     *
     * @return bool
     */
    public function hasMessageDecoration(string $message, bool $activeOnProductDisplayPage, bool $activeOnProductListingPage, bool $activeOnCheckoutPage): bool;

    /**
     * @param string $url
     * @param string $position
     * @param bool $activeOnProductDisplayPage
     * @param bool $activeOnProductListingPage
     * @param bool $activeOnCheckoutPage
     *
     * @return bool
     */
    public function hasBannerDecoration(string $url, string $position, bool $activeOnProductDisplayPage, bool $activeOnProductListingPage, bool $activeOnCheckoutPage): bool;
}
