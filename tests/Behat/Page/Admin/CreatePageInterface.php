<?php

declare(strict_types=1);

namespace Tests\Urbanara\CatalogPromotionPlugin\Behat\Page\Admin;

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
     * @param float $amount
     */
    public function fillActionPercentage($amount);

    /**
     * @param string $channelName
     * @param string $option
     * @param string $value
     */
    public function fillActionForChannel($channelName, $option, $value);

    /**
     * @param string $name
     */
    public function checkChannel($name);

    /**
     * @param int $priority
     */
    public function setItsPriority($priority);

    /**
     * @param string $skuList
     */
    public function setIsProductSkuRuleCriteria(string $skuList);

    /**
     * @param string $criteria
     * @param int $numWeeks
     */
    public function setDeliveryTimeRuleCriteria(string $criteria, int $numWeeks);

    /**
     * @param bool $activeOnProductDisplayPage
     * @param bool $activeOnProductListingPage
     * @param bool $activeOnCheckoutPage
     */
    public function addStrikethroughDecoration(bool $activeOnProductDisplayPage, bool $activeOnProductListingPage, bool $activeOnCheckoutPage): void;

    /**
     * @param string $message
     * @param string $localeCode
     * @param bool $activeOnProductDisplayPage
     * @param bool $activeOnProductListingPage
     * @param bool $activeOnCheckoutPage
     */
    public function addMessageDecoration(string $message, string $localeCode, bool $activeOnProductDisplayPage, bool $activeOnProductListingPage, bool $activeOnCheckoutPage): void;

    /**
     * @param string $url
     * @param string $position
     * @param bool $activeOnProductDisplayPage
     * @param bool $activeOnProductListingPage
     * @param bool $activeOnCheckoutPage
     */
    public function addBannerDecoration(string $url, string $position, bool $activeOnProductDisplayPage, bool $activeOnProductListingPage, bool $activeOnCheckoutPage): void;
}
