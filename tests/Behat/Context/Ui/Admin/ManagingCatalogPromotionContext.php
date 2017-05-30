<?php

namespace Tests\Urbanara\CatalogPromotionPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Tester\Exception\PendingException;
use PhpSpec\Exception\Example\SkippingException;
use Sylius\Behat\Context\Transform\ProductContext;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Tests\Urbanara\CatalogPromotionPlugin\Behat\Page\Admin\CreatePageInterface;
use Tests\Urbanara\CatalogPromotionPlugin\Behat\Page\Admin\IndexPageInterface;
use Tests\Urbanara\CatalogPromotionPlugin\Behat\Page\Admin\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingCatalogPromotionContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var CreatePageInterface
     */
    private $createPage;

    /**
     * @var IndexPageInterface
     */
    private $indexPage;

    /**
     * @var UpdatePageInterface
     */
    private $updatePage;

    /**
     * @var ProductContext
     */
    private $productContext;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param CreatePageInterface $createPage
     * @param IndexPageInterface $indexPage
     * @param UpdatePageInterface $updatePage
     * @param ProductContext $productContext
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        CreatePageInterface $createPage,
        IndexPageInterface $indexPage,
        UpdatePageInterface $updatePage,
        ProductContext $productContext
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->createPage = $createPage;
        $this->indexPage = $indexPage;
        $this->updatePage = $updatePage;
        $this->productContext = $productContext;
    }

    /**
     * @When I create a new catalog promotion
     */
    public function iCreateANewCatalogPromotion()
    {
        $this->createPage->open();
    }

    /**
     * @When /^I modify (this catalog promotion)$/
     */
    public function iWantToModifyThisPromotion(CatalogPromotionInterface $catalogPromotion)
    {
        $this->updatePage->open(['id' => $catalogPromotion->getId()]);
    }

    /**
     * @When I save my changes
     * @When I try to save my changes
     */
    public function iSaveMyChanges()
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @When I name it :name
     * @When I do not name it
     * @When I remove its name
     */
    public function iNameIt($name = null)
    {
        $this->createPage->nameIt($name);
    }

    /**
     * @When I specify its code as :code
     * @When I do not specify its code
     */
    public function iSpecifyItsCodeAs($code = null)
    {
        $this->createPage->specifyCode($code);
    }

    /**
     * @When I add it
     * @When I try to add it
     */
    public function iAddIt()
    {
        $this->createPage->create();
    }

    /**
     * @When I make it exclusive
     */
    public function iMakeItExclusive()
    {
        $this->createPage->makeExclusive();
    }

    /**
     * @When I make it available from :startsDate to :endsDate
     */
    public function iMakeItAvailableFromTo(\DateTime $startsDate, \DateTime $endsDate)
    {
        $this->createPage->setStartsAt($startsDate);
        $this->createPage->setEndsAt($endsDate);
    }

    /**
     * @When /^I specify the percentage discount with amount of "([^"]+%)"$/
     */
    public function iSpecifyThePercentageDiscountWithAmountOf($amount)
    {
        $this->createPage->chooseActionType('Percentage discount');
        $this->createPage->fillActionPercentage($amount);
    }

    /**
     * @When /^I add the fixed value discount with amount of "(?:€|£|\$)([^"]+)" for "([^"]+)" channel$/
     */
    public function iAddTheFixedValueDiscountWithAmountOfForChannel($amount = null, $channelName)
    {
        $this->createPage->chooseActionType('Fixed discount');
        $this->createPage->fillActionAmount($channelName, $amount);
    }

    /**
     * @When I don't add the price for fixed value discount for the :channelName channel
     */
    public function iDontAddThePriceForFixedValueDiscountWithForTheChannel($channelName)
    {
        $this->createPage->chooseActionType('Fixed discount');
        $this->createPage->fillActionAmount($channelName, null);
    }

    /**
     * @When I make it applicable for the :channelName channel
     */
    public function iMakeItApplicableForTheChannel($channelName)
    {
        $this->createPage->checkChannel($channelName);
    }

    /**
     * @When I browse catalog promotions
     */
    public function iBrowseCatalogPromotions()
    {
        $this->indexPage->open();
    }

    /**
     * @When I delete the :catalogPromotion catalog promotion
     */
    public function iDeleteTheCatalogPromotion(CatalogPromotionInterface $catalogPromotion)
    {
        $this->sharedStorage->set('catalog_promotion', $catalogPromotion);

        $this->indexPage->open();
        $this->indexPage->deleteResourceOnPage(['name' => $catalogPromotion->getName()]);
    }

    /**
     * @Then the :catalogPromotionName catalog promotion should appear in the registry
     * @Then this catalog promotion should still be named :catalogPromotionName
     * @Then the :catalogPromotionName catalog promotion should exist in the registry
     */
    public function theCatalogPromotionShouldAppearInTheRegistry($catalogPromotionName)
    {
        $this->iBrowseCatalogPromotions();

        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $catalogPromotionName]));
    }

    /**
     * @Then the :catalogPromotion catalog promotion should be exclusive
     */
    public function thisCatalogPromotionShouldBeExclusive(CatalogPromotionInterface $catalogPromotion)
    {
        $this->iBrowseCatalogPromotions();

        Assert::true($this->indexPage->isExclusive($catalogPromotion->getCode()));
    }

    /**
     * @Then the :catalogPromotion catalog promotion should be available from :startsDate to :endsDate
     */
    public function thePromotionShouldBeAvailableFromTo(
        CatalogPromotionInterface $catalogPromotion,
        \DateTime $startsDate,
        \DateTime $endsDate
    ) {
        $this->iWantToModifyThisPromotion($catalogPromotion);

        Assert::true($this->updatePage->hasStartsAt($startsDate));
        Assert::true($this->updatePage->hasEndsAt($endsDate));
    }

    /**
     * @Then /^the ("[^"]+" catalog promotion) should give "([^"]+)%" discount$/
     */
    public function theCatalogPromotionShouldGivePercentageDiscount(CatalogPromotionInterface $catalogPromotion, $amount)
    {
        $this->iWantToModifyThisPromotion($catalogPromotion);

        Assert::eq($this->updatePage->getAmount(), $amount);
    }

    /**
     * @Then /^the ("[^"]+" catalog promotion) should give "(?:€|£|\$)([^"]+)" discount for ("[^"]+" channel)$/
     */
    public function thisCatalogPromotionShouldGiveDiscountForChannel(
        CatalogPromotionInterface $catalogPromotion,
        $amount,
        ChannelInterface $channel
    ) {
        $this->iWantToModifyThisPromotion($catalogPromotion);

        Assert::eq($this->updatePage->getValueForChannel($channel->getCode()), $amount);
    }

    /**
     * @Then the :catalogPromotion catalog promotion should be applicable for the :channelName channel
     */
    public function thePromotionShouldBeApplicableForTheChannel(CatalogPromotionInterface $catalogPromotion, $channelName)
    {
        $this->iWantToModifyThisPromotion($catalogPromotion);

        Assert::true($this->updatePage->checkChannelsState($channelName));
    }

    /**
     * @Then there should be a single catalog promotion
     */
    public function thereShouldBeASingleCatalogPromotion()
    {
        Assert::same(
            1,
            $this->indexPage->countItems(),
            'I should see %s promotions but i see only %2$s'
        );
    }

    /**
     * @Then I should be notified that a catalog promotion with this code already exists
     */
    public function iShouldBeNotifiedThatACatalogPromotionWithThisCodeAlreadyExists()
    {
        Assert::same($this->createPage->getValidationMessage('code'), 'The catalog promotion with given code already exists.');
    }

    /**
     * @Then there should still be only one catalog promotion with code :code
     */
    public function thereShouldStillBeOnlyOneCatalogPromotionWithCode($code)
    {
        $this->iBrowseCatalogPromotions();

        Assert::true($this->indexPage->isSingleResourceOnPage(['code' => $code]));
    }

    /**
     * @Then /^I should be notified that a ([^"]+) is required$/
     */
    public function iShouldBeNotifiedThatIsRequired($element)
    {
        Assert::same(
            $this->createPage->getValidationMessage($element),
            sprintf('Please enter catalog promotion %s.', $element)
        );
    }

    /**
     * @Then the catalog promotion with :element :name should not be added
     */
    public function promotionWithElementValueShouldNotBeAdded($element, $name)
    {
        $this->iBrowseCatalogPromotions();

        Assert::false($this->indexPage->isSingleResourceOnPage([$element => $name]));
    }

    /**
     * @Then I should be notified that a/the catalog promotion cannot end before it starts
     */
    public function iShouldBeNotifiedThatPromotionCannotEndBeforeItsEvenStart()
    {
        Assert::same($this->createPage->getValidationMessage('ends_at'), 'End date cannot be set prior start date.');
    }

    /**
     * @Then I should be notified that a catalog promotion cannot be created without price for enabled channel
     */
    public function iShouldBeNotifiedThatPricesInAllChannelsMustBeDefined()
    {
        Assert::contains(
            $this->createPage->getValidationMessage('price_for_channel'),
            'Discounts cannot be empty for enabled channels.'
        );
    }

    /**
     * @Then I should be notified that a catalog promotion cannot be created with negative fixed discount
     */
    public function iShouldBeNotifiedThatPricesCannotBeNegative()
    {
        Assert::contains(
            $this->createPage->getValidationMessage('price_for_channel'),
            'The catalog promotion cannot be lower than 0.'
        );
    }

    /**
     * @Then /^(this catalog promotion) should no longer exist in the promotion registry$/
     */
    public function thisCatalogPromotionShouldNoLongerExistInThePromotionRegistry(CatalogPromotionInterface $catalogPromotion)
    {
        $this->iBrowseCatalogPromotions();

        Assert::false($this->indexPage->isSingleResourceOnPage(['code' => $catalogPromotion->getCode()]));
    }

    /**
     * @Then the code field should be disabled
     */
    public function theCodeFieldShouldBeDisabled()
    {
        Assert::true($this->updatePage->isCodeDisabled());
    }

    /**
     * @When I set its priority to :priority
     */
    public function iSetItsPriorityTo($priority)
    {
        $this->createPage->setItsPriority($priority);
    }

    /**
     * @Then the :catalogPromotion catalog promotion should have priority set to :arg2
     */
    public function theCatalogPromotionShouldHavePrioritySetTo(CatalogPromotionInterface $catalogPromotion, $priority)
    {
        $this->iBrowseCatalogPromotions();

        Assert::same($this->indexPage->getPriority($catalogPromotion->getCode()), $priority);
    }

    /**
     * @Then I should see :count catalog promotions on the list
     */
    public function iShouldSeePromotionsOnTheList($count)
    {
        $actualCount = $this->indexPage->countItems();

        Assert::same(
            (int) $count,
            $actualCount,
            'There should be %s catalog promotion, but there\'s %2$s.'
        );
    }

    /**
     * @Then the first catalog promotion on the list should have :field :value
     */
    public function theFirstPromotionOnTheListShouldHave($field, $value)
    {
        $fields = $this->indexPage->getColumnFields($field);
        $actualValue = reset($fields);

        Assert::same(
            $actualValue,
            $value,
            sprintf('Expected first catalog promotion\'s %s to be "%s", but it is "%s".', $field, $value, $actualValue)
        );
    }

    /**
     * @Then the last catalog promotion on the list should have :field :value
     */
    public function theLastPromotionOnTheListShouldHave($field, $value)
    {
        $fields = $this->indexPage->getColumnFields($field);
        $actualValue = end($fields);

        Assert::same(
            $actualValue,
            $value,
            sprintf('Expected last catalog promotion\'s %s to be "%s", but it is "%s".', $field, $value, $actualValue)
        );
    }

    /**
     * @Then I should be notified that a code cannot contain any spaces
     */
    public function iShouldBeNotifiedThatACodeCannotContainAnySpaces()
    {
        Assert::contains(
            $this->createPage->getValidationMessage('code'),
            'Catalog promotion code can only be comprised of letters, numbers, dashes and underscores.'
        );
    }

    /**
     * @Given product :productName has a delivery time greater than :deliveryWeeks weeks
     */
    public function productHasADeliveryTimeGreaterThanWeeks(string $productName, int $deliveryWeeks)
    {
        $eta = $this->productContext->getProductByName($productName)->getAttributeByCodeAndLocale('eta', 'en');

        $etaDays = !$eta ? 21 : intval($eta->getValue());
        $etaWeeks = ceil($etaDays / 7);
        Assert::greaterThan($etaWeeks, $deliveryWeeks);
    }

    /**
     * TODO: Need to find out how to test with javascript enabled
     * @When I set rule delivery time :criteria than :numWeeks weeks
     */
    public function iSetRuleDeliveryTimeThanWeeks(string $criteria, int $numWeeks)
    {
        throw new PendingException();
    }

    /**
     *  @Then the :catalogPromotion catalog promotion should be applicable for delivery time :criteria than :numWeeks weeks
     */
    public function theCatalogPromotionShouldBeApplicableForDeliveryTimeThanWeeks(
        CatalogPromotionInterface $catalogPromotion,
        string $criteria,
        int $numWeeks
    )
    {
        $this->iWantToModifyThisPromotion($catalogPromotion);
        Assert::true($this->updatePage->hasMatchingDeliveryTimeRule($criteria, $numWeeks));
    }

    /**
     * @When I make this catalog promotion applicable for product sku in the list :skuTextList only
     */
    public function iMakeThisCatalogPromotionApplicableForProductSkuInTheListOnly(string $skuTextList)
    {
        $this->createPage->setIsProductSkuRuleCriteria($skuTextList);
        throw new PendingException();
    }

    /**
     * @Then this catalog promotion should be applicable for product sku :sku
     */
    public function thisCatalogPromotionShouldBeApplicableForProductSku(string $sku)
    {
        throw new PendingException();
    }

    /**
     * @Then this catalog promotion should not be applicable for product sku :sku
     */
    public function thisCatalogPromotionShouldNotBeApplicableForProductSku(string $sku)
    {
        throw new PendingException();
    }

    /**
     * @When I add strikethrough decoration available on all pages
     */
    public function iAddStrikethroughDecorationAvailableOnAllPages()
    {
        $this->createPage->addStrikethroughDecoration(true, true, true);
    }

    /**
     * @Then the :catalogPromotion catalog promotion should be decorated with strikethrough on all pages
     */
    public function theCatalogPromotionShouldBeDecoratedWithStrikethroughOnAllPages(CatalogPromotionInterface $catalogPromotion)
    {
        $this->iWantToModifyThisPromotion($catalogPromotion);

        Assert::true($this->updatePage->hasStrikethroughDecoration(true, true, true));
    }

    /**
     * @When I add :message message decoration available on all pages
     */
    public function iAddMessageDecorationAvailableOnAllPages($message)
    {
        $this->createPage->addMessageDecoration($message, true, true, true);
    }

    /**
     * @Then the :catalogPromotion catalog promotion should be decorated with message :message on all pages
     */
    public function theCatalogPromotionShouldBeDecoratedWithMessageOnAllPages(CatalogPromotionInterface $catalogPromotion, $message)
    {
        $this->iWantToModifyThisPromotion($catalogPromotion);

        Assert::true($this->updatePage->hasMessageDecoration($message, true, true, true));
    }

    /**
     * @When I add top-right :url banner decoration available on all pages
     */
    public function iAddTopRightBannerDecorationAvailableOnAllPages($url)
    {
        $this->createPage->addBannerDecoration($url, 'Top-right', true, true, true);
    }

    /**
     * @Then the :catalogPromotion catalog promotion should be decorated with top-right :url banner on all pages
     */
    public function theCatalogPromotionShouldBeDecoratedWithTopRightBannerOnAllPages(CatalogPromotionInterface $catalogPromotion, $url)
    {
        $this->iWantToModifyThisPromotion($catalogPromotion);

        Assert::true($this->updatePage->hasBannerDecoration($url, 'Top-right', true, true, true));
    }
}
