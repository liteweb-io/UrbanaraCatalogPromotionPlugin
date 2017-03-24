<?php

namespace Tests\Urbanara\CatalogPromotionPlugin\Behat\Page\Admin;

use Sylius\Behat\Behaviour\ChecksCodeImmutability;
use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ChecksCodeImmutability;

    /**
     * {@inheritdoc}
     */
    public function hasStartsAt(\DateTime $dateTime)
    {
        $timestamp = $dateTime->getTimestamp();

        return $this->getElement('starts_at_date')->getValue() === date('Y-m-d', $timestamp)
            && $this->getElement('starts_at_time')->getValue() === date('H:i', $timestamp);
    }

    /**
     * {@inheritdoc}
     */
    public function hasEndsAt(\DateTime $dateTime)
    {
        $timestamp = $dateTime->getTimestamp();

        return $this->getElement('ends_at_date')->getValue() === date('Y-m-d', $timestamp)
            && $this->getElement('ends_at_time')->getValue() === date('H:i', $timestamp);
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount()
    {
        return $this->getElement('amount')->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function getValueForChannel($channelCode)
    {
        return $this->getElement('channel_value', ['%channel_code%' => $channelCode])->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function checkChannelsState($channelName)
    {
        $field = $this->getDocument()->findField($channelName);

        return (bool) $field->getValue();
    }

    /**
     * {@inheritdoc}
     */
    protected function getCodeElement()
    {
        return $this->getElement('code');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return [
            'amount' => '#urbanara_catalog_promotion_discountConfiguration_percentage',
            'channel_value' => '#urbanara_catalog_promotion_discountConfiguration_values_%channel_code%',
            'code' => '#urbanara_catalog_promotion_code',
            'ends_at_date' => '#urbanara_catalog_promotion_endsAt_date',
            'ends_at_time' => '#urbanara_catalog_promotion_endsAt_time',
            'starts_at_date' => '#urbanara_catalog_promotion_startsAt_date',
            'starts_at_time' => '#urbanara_catalog_promotion_startsAt_time',
        ];
    }
}
