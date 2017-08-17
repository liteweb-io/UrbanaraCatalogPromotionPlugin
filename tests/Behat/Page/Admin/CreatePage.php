<?php

declare(strict_types=1);

namespace Tests\Urbanara\CatalogPromotionPlugin\Behat\Page\Admin;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Behaviour\NamesIt;
use Sylius\Behat\Behaviour\SpecifiesItsCode;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Urbanara\CatalogPromotionPlugin\Form\Type\Rule\IsProductDeliveryTimeInScopeType;
use Urbanara\CatalogPromotionPlugin\Form\Type\Rule\IsProductSkuType;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use NamesIt;
    use SpecifiesItsCode;

    const BUTTON_ADD_RULE = 'Add rule';
    const XPATH_CATALOG_PROMOTION_TYPE_DROPDOWN = '//*[@id="urbanara_catalog_promotion_rules_0_type"]';
    const XPATH_DROPDOWN_DELIVERY_TIME_WEEKS = '//*[@id="urbanara_catalog_promotion_rules_0_configuration_weeks"]';
    const XPATH_DROPDOWN_DELIVERY_TIME_CRITERIA = '//*[@id="urbanara_catalog_promotion_rules_0_configuration_criteria"]';
    const XPATH_DROPDOWN_PRODUCT_SKU_LIST = '//*[@id="urbanara_catalog_promotion_rules_0_configuration_sku_list"]';

    public function makeExclusive()
    {
        $this->getDocument()->checkField('Exclusive');
    }

    /**
     * {@inheritdoc}
     */
    public function setStartsAt(\DateTime $dateTime)
    {
        $timestamp = $dateTime->getTimestamp();

        $this->getDocument()->fillField('urbanara_catalog_promotion_startsAt_date', date('Y-m-d', $timestamp));
        $this->getDocument()->fillField('urbanara_catalog_promotion_startsAt_time', date('H:i', $timestamp));
    }

    /**
     * {@inheritdoc}
     */
    public function setEndsAt(\DateTime $dateTime)
    {
        $timestamp = $dateTime->getTimestamp();

        $this->getDocument()->fillField('urbanara_catalog_promotion_endsAt_date', date('Y-m-d', $timestamp));
        $this->getDocument()->fillField('urbanara_catalog_promotion_endsAt_time', date('H:i', $timestamp));
    }

    /**
     * {@inheritdoc}
     */
    public function chooseActionType($type)
    {
        $this->getDocument()->selectFieldOption('urbanara_catalog_promotion_discountType', $type);
    }

    /**
     * {@inheritdoc}
     */
    public function fillActionAmount($field, $amount)
    {
        /** @var NodeElement $element */
        $element = $this->getDocument()->find('css', '#urbanara_catalog_promotion_discountConfiguration_values');
        $element->fillField($field, $amount);
    }

    /**
     * {@inheritdoc}
     */
    public function fillActionPercentage($amount)
    {
        /** @var NodeElement $element */
        $element = $this->getDocument()->find('css', '#urbanara_catalog_promotion_discountConfiguration');
        $element->fillField('Percentage', $amount);
    }

    /**
     * {@inheritdoc}
     */
    public function fillActionForChannel($channelName, $option, $value)
    {
        $channel = $this
            ->getDocument()
            ->find('css', sprintf('.configuration .field:contains("%s")', $channelName))
        ;

        $channel->fillField($option, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function checkChannel($name)
    {
        $this->getDocument()->checkField($name);
    }

    /**
     * {@inheritdoc}
     */
    public function setItsPriority($priority)
    {
        $this->getDocument()->fillField('Priority', $priority);
    }

    /**
     * @param string $skuList
     */
    public function setIsProductSkuRuleCriteria(string $skuList)
    {
        $this->getSession()->getPage()->clickLink(self::BUTTON_ADD_RULE);
        $this->getDriver()->selectOption(
            self::XPATH_CATALOG_PROMOTION_TYPE_DROPDOWN,
            IsProductSkuType::FORM_TYPE_DROPDOWN_OPTION
        );
        $this->getDriver()->setValue(
            self::XPATH_DROPDOWN_PRODUCT_SKU_LIST,
            str_replace(',', "\n", $skuList)
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return [
            'code' => '#urbanara_catalog_promotion_code',
            'price_for_channel' => '#urbanara_catalog_promotion_discountConfiguration_values',
            'ends_at' => '#urbanara_catalog_promotion_endsAt',
            'name' => '#urbanara_catalog_promotion_name',
        ];
    }

    /**
     * @param int    $numWeeks
     * @param string $criteria
     */
    public function setDeliveryTimeRuleCriteria(string $criteria, int $numWeeks)
    {
        $this->getSession()->getPage()->clickLink(self::BUTTON_ADD_RULE);
        $this->getDriver()->selectOption(
            self::XPATH_CATALOG_PROMOTION_TYPE_DROPDOWN,
            IsProductDeliveryTimeInScopeType::FORM_TYPE_DROPDOWN_OPTION
        );
        $this->getDriver()->selectOption(self::XPATH_DROPDOWN_DELIVERY_TIME_CRITERIA, $criteria);
        $this->getDriver()->setValue(self::XPATH_DROPDOWN_DELIVERY_TIME_WEEKS, $numWeeks);
    }

    /**
     * {@inheritdoc}
     */
    public function addStrikethroughDecoration(bool $activeOnProductDisplayPage, bool $activeOnProductListingPage, bool $activeOnCheckoutPage): void
    {
        $this->getDocument()->clickLink('Add decoration');

        /** @var NodeElement[] $decorations */
        $decorations = $this->getDocument()->findAll('css', '#catalog_promotion_decorations [data-form-type="collection"]');
        $decoration = end($decorations);

        $decoration->selectFieldOption('Type', 'Strikethrough');

        if ($activeOnProductDisplayPage) {
            $decoration->checkField('Active on product display page');
        }

        if ($activeOnProductListingPage) {
            $decoration->checkField('Active on product listing page');
        }

        if ($activeOnCheckoutPage) {
            $decoration->checkField('Active on checkout page');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addMessageDecoration(string $message, string $localeCode, bool $activeOnProductDisplayPage, bool $activeOnProductListingPage, bool $activeOnCheckoutPage): void
    {
        $this->getDocument()->clickLink('Add decoration');

        /** @var NodeElement[] $decorations */
        $decorations = $this->getDocument()->findAll('css', '#catalog_promotion_decorations [data-form-type="collection"]');
        $decoration = end($decorations);

        $decoration->selectFieldOption('Type', 'Message');
        $decoration->fillField('Message', $message);

        if ($activeOnProductDisplayPage) {
            $decoration->checkField('Active on product display page');
        }

        if ($activeOnProductListingPage) {
            $decoration->checkField('Active on product listing page');
        }

        if ($activeOnCheckoutPage) {
            $decoration->checkField('Active on checkout page');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addBannerDecoration(string $url, string $position, bool $activeOnProductDisplayPage, bool $activeOnProductListingPage, bool $activeOnCheckoutPage): void
    {
        $this->getDocument()->clickLink('Add decoration');

        /** @var NodeElement[] $decorations */
        $decorations = $this->getDocument()->findAll('css', '#catalog_promotion_decorations [data-form-type="collection"]');
        $decoration = end($decorations);

        $decoration->selectFieldOption('Type', 'Banner');
        $decoration->fillField('URL', $url);
        $decoration->selectFieldOption('Position', $position);

        if ($activeOnProductDisplayPage) {
            $decoration->checkField('Active on product display page');
        }

        if ($activeOnProductListingPage) {
            $decoration->checkField('Active on product listing page');
        }

        if ($activeOnCheckoutPage) {
            $decoration->checkField('Active on checkout page');
        }
    }
}
