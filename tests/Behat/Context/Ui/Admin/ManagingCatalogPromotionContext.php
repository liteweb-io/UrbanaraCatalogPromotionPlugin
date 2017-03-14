<?php

namespace Tests\Acme\SyliusCatalogPromotionBundle\Behat\Context\Ui\Admin;

use Acme\SyliusCatalogPromotionBundle\Entity\CatalogPromotionInterface;
use Behat\Behat\Context\Context;
use Tests\Acme\SyliusCatalogPromotionBundle\Behat\Page\Admin\CreatePageInterface;
use Tests\Acme\SyliusCatalogPromotionBundle\Behat\Page\Admin\IndexPageInterface;
use Tests\Acme\SyliusCatalogPromotionBundle\Behat\Page\Admin\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingCatalogPromotionContext implements Context
{
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
     * @param CreatePageInterface $createPage
     * @param IndexPageInterface $indexPage
     * @param UpdatePageInterface $updatePage
     */
    public function __construct(CreatePageInterface $createPage, IndexPageInterface $indexPage, UpdatePageInterface $updatePage)
    {
        $this->createPage = $createPage;
        $this->indexPage = $indexPage;
        $this->updatePage = $updatePage;
    }

    /**
     * @When I create a new catalog promotion
     */
    public function iCreateANewCatalogPromotion()
    {
        $this->createPage->open();
    }

    /**
     * @When I name it :name
     */
    public function iNameIt($name = null)
    {
        $this->createPage->nameIt($name);
    }

    /**
     * @When I specify its code as :code
     */
    public function iSpecifyItsCodeAs($code = null)
    {
        $this->createPage->specifyCode($code);
    }

    /**
     * @When I add it
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
     * @Then the :catalogPromotionName catalog promotion should appear in the registry
     */
    public function theCatalogPromotionShouldAppearInTheRegistry($catalogPromotionName)
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $catalogPromotionName]));
    }

    /**
     * @Then the :catalogPromotion catalog promotion should be exclusive
     */
    public function thisCatalogPromotionShouldBeExclusive(CatalogPromotionInterface $catalogPromotion)
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isExclusive($catalogPromotion->getCode()));
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
     * @Then the :catalogPromotion catalog promotion should be available from :startsDate to :endsDate
     */
    public function thePromotionShouldBeAvailableFromTo(CatalogPromotionInterface $catalogPromotion, \DateTime $startsDate, \DateTime $endsDate)
    {
        $this->updatePage->open(['id' => $catalogPromotion->getId()]);

        Assert::true($this->updatePage->hasStartsAt($startsDate));
        Assert::true($this->updatePage->hasEndsAt($endsDate));
    }

    /**
     * @When /^I specify the percentage discount with amount of "([^"]+%)"$/
     */
    public function iSpecifyThePercentageDiscountWithAmountOf($amount)
    {
        $this->createPage->chooseActionType('Percentage discount');
        $this->createPage->fillActionAmount('Percentage', $amount);
    }

    /**
     * @Then /^the ("[^"]+" catalog promotion) should give "([^"]+)%" discount$/
     */
    public function theCatalogPromotionShouldGivePercentageDiscount(CatalogPromotionInterface $catalogPromotion, $amount)
    {
        $this->updatePage->open(['id' => $catalogPromotion->getId()]);

        Assert::eq($this->updatePage->getAmount(), $amount);
    }
}
