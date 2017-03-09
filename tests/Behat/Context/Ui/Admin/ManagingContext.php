<?php

namespace Tests\Acme\SyliusCatalogPromotionBundle\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Component\Core\Model\PromotionInterface;
use Tests\Acme\SyliusCatalogPromotionBundle\Behat\Page\Admin\CreatePageInterface;
use Tests\Acme\SyliusCatalogPromotionBundle\Behat\Page\Admin\IndexPageInterface;
use Webmozart\Assert\Assert;

final class ManagingContext implements Context
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
     * @param CreatePageInterface $createPage
     * @param IndexPageInterface $indexPage
     */
    public function __construct(CreatePageInterface $createPage, IndexPageInterface $indexPage)
    {
        $this->createPage = $createPage;
        $this->indexPage = $indexPage;
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
    public function thisCatalogPromotionShouldBeExclusive($catalogPromotion)
    {
        Assert::true($this->indexPage->isExclusive($catalogPromotion->getCode()));
    }
}
