<?php

namespace Tests\Urbanara\CatalogPromotionPlugin\Behat\Page\Admin;

use Sylius\Behat\Behaviour\ChecksCodeImmutability;
use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Behat\Mink\Element\NodeElement;
use Urbanara\CatalogPromotionPlugin\Form\Type\Rule\IsProductSkuInListType;
use Urbanara\CatalogPromotionPlugin\Form\Type\Rule\IsProductDeliveryTimeInScopeType;

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
    public function hasMatchingDeliveryTimeRule(string $criteria, int $numWeeks) : bool
    {
        $document = $this->getDocument();

        $rule = $document->find('css', 'div#urbanara_catalog_promotion_rules_0');
        if (!($rule instanceof NodeElement)) {
            return false;
        }

        $ruleTypeElement = $rule->find('css', "select[id^=urbanara_catalog_promotion_rules_0_type]");
        if (!($ruleTypeElement instanceof NodeElement) || $ruleTypeElement->getValue() != 'is_delivery_time_in_scope') {
            return false;
        }

        $criteriaElement = $rule->find('css', "select[id^=urbanara_catalog_promotion_rules_0_criteria]");
        if (!($criteriaElement instanceof NodeElement) || $criteriaElement->getValue() != $criteria) {
            return false;
        }

        $numWeeksElement = $rule->find('css', "select[id^=urbanara_catalog_promotion_rules_0_weeks]");
        if (!($numWeeksElement instanceof NodeElement) || $numWeeksElement->getValue() != $numWeeks) {
            return false;
        }

        return true;
    }

    /**
     * @param string $sku
     *
     * @return bool
     */
    public function hasMatchingIsProductSkuRule(string $sku) : bool
    {
//        $document = $this->getDocument();
//
//        $rule = $document->find('css', 'div#urbanara_catalog_promotion_rules_0');
//        if (!($rule instanceof NodeElement)) {
//            return false;
//        }
//
//        $ruleTypeElement = $rule->find('css', "select[id^=urbanara_catalog_promotion_rules_0_type]");
//        if (!($ruleTypeElement instanceof NodeElement) || $ruleTypeElement->getValue() != 'is_delivery_time_in_scope') {
//            return false;
//        }
//
//        $criteriaElement = $rule->find('css', "select[id^=urbanara_catalog_promotion_rules_0_criteria]");
//        if (!($criteriaElement instanceof NodeElement) || $criteriaElement->getValue() != $sku) {
//            return false;
//        }
//
//        $numWeeksElement = $rule->find('css', "select[id^=urbanara_catalog_promotion_rules_0_weeks]");
//        if (!($numWeeksElement instanceof NodeElement) || $numWeeksElement->getValue() != $sku) {
//            return false;
//        }
//
//        return true;
        return false;
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
