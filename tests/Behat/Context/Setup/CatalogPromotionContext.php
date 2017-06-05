<?php

declare(strict_types=1);

namespace Tests\Urbanara\CatalogPromotionPlugin\Behat\Context\Setup;

use Urbanara\CatalogPromotionPlugin\Action\PercentageCatalogDiscountCommand;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogRule;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogRuleInterface;
use Urbanara\CatalogPromotionPlugin\Rule\IsFromTaxonRuleChecker;
use Urbanara\CatalogPromotionPlugin\Rule\IsProductRuleChecker;
use Behat\Behat\Tester\Exception\PendingException;
use Urbanara\CatalogPromotionPlugin\Action\FixedCatalogDiscountCommand;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class CatalogPromotionContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var FactoryInterface
     */
    private $catalogPromotionFactory;

    /**
     * @var FactoryInterface
     */
    private $catalogRulePromotionFactory;

    /**
     * @var RepositoryInterface
     */
    private $catalogPromotionRepository;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param FactoryInterface $catalogPromotionFactory
     * @param FactoryInterface $catalogRulePromotionFactory
     * @param RepositoryInterface $catalogPromotionRepository
     * @param ObjectManager $manager
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        FactoryInterface $catalogPromotionFactory,
        FactoryInterface $catalogRulePromotionFactory,
        RepositoryInterface $catalogPromotionRepository,
        ObjectManager $manager
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->catalogPromotionRepository = $catalogPromotionRepository;
        $this->catalogRulePromotionFactory = $catalogRulePromotionFactory;
        $this->catalogPromotionFactory = $catalogPromotionFactory;
        $this->manager = $manager;
    }

    /**
     * @Given there is a :catalogPromotionName catalog promotion
     */
    public function thereIsACatalogPromotion($catalogPromotionName)
    {
        $catalogPromotion = $this->createPromotion($catalogPromotionName);

        $this->saveCatalogPromotion($catalogPromotion);
    }

    /**
     * @Given there is a :catalogPromotionName catalog promotion identified by :catalogPromotionCode code
     */
    public function thereIsACatalogPromotionIdentifiedByCode($catalogPromotionName, $catalogPromotionCode)
    {
        $catalogPromotion = $this->createPromotion($catalogPromotionName);
        $catalogPromotion->setCode($catalogPromotionCode);

        $this->saveCatalogPromotion($catalogPromotion);
    }

    /**
     * @Given there is an exclusive :catalogPromotionName catalog promotion
     */
    public function thereIsAnExclusiveCatalogPromotion($catalogPromotionName)
    {
        $catalogPromotion = $this->createPromotion($catalogPromotionName);
        $catalogPromotion->setExclusive(true);

        $this->saveCatalogPromotion($catalogPromotion);
    }

    /**
     * @Given /^there is a "([^"]+)" catalog promotion with priority (\-?\d+)$/
     */
    public function thereIsACatalogPromotionWithPriority($catalogPromotionName, $priority)
    {
        $catalogPromotion = $this->createPromotion($catalogPromotionName);
        $catalogPromotion->setPriority($priority);

        $this->saveCatalogPromotion($catalogPromotion);
    }

    /**
     * @Given there is an exclusive catalog promotion :catalogPromotionName with priority :priority
     */
    public function thereIsAnExclusiveCatalogPromotionWithPriority($catalogPromotionName, $priority)
    {
        $catalogPromotion = $this->createPromotion($catalogPromotionName);
        $catalogPromotion->setPriority($priority);
        $catalogPromotion->setExclusive(true);

        $this->saveCatalogPromotion($catalogPromotion);
    }

    /**
     * @Given /^(it) gives ("(?:€|£|\$)[^"]+") discount on every product$/
     * @Given /^(it) gives ("(?:€|£|\$)[^"]+") off$/
     */
    public function itGivesDiscountOnEveryProduct(CatalogPromotionInterface $catalogPromotion, $discount)
    {
        $channel = $this->sharedStorage->get('channel');

        $catalogPromotion->addChannel($channel);
        $catalogPromotion->setDiscountConfiguration(array_merge($catalogPromotion->getDiscountConfiguration(), ['values' => [$channel->getCode() => $discount]]));
        $catalogPromotion->setDiscountType(FixedCatalogDiscountCommand::TYPE);

        $this->manager->flush();
    }

    /**
     * @Given /^(it) gives (\d+)% discount on every product$/
     */
    public function itGivesDiscountOnEveryProduct2(CatalogPromotionInterface $catalogPromotion, $discount)
    {
        $channel = $this->sharedStorage->get('channel');

        $catalogPromotion->addChannel($channel);
        $catalogPromotion->setDiscountConfiguration(array_merge($catalogPromotion->getDiscountConfiguration(), ['percentage' => $discount / 100]));
        $catalogPromotion->setDiscountType(PercentageCatalogDiscountCommand::TYPE);

        $this->manager->flush();
    }

    /**
     * @Given /^(it) is currently available$/
     */
    public function itIsCurrentlyAvailable(CatalogPromotionInterface $catalogPromotion)
    {
        $catalogPromotion->setStartsAt(new \DateTime('-3 days'));
        $catalogPromotion->setEndsAt(new \DateTime('3 days'));

        $this->manager->flush();
    }

    /**
     * @Given the :catalogPromotion catalog promotion has already expired
     */
    public function theCatalogPromotionHasAlreadyExpired(CatalogPromotionInterface $catalogPromotion)
    {
        $catalogPromotion->setEndsAt(new \DateTime('-3 days'));

        $this->manager->flush();
    }

    /**
     * @Given the :catalogPromotion catalog promotion has not started yet
     */
    public function theCatalogPromotionHasNotStartedYet(CatalogPromotionInterface $catalogPromotion)
    {
        $catalogPromotion->setStartsAt(new \DateTime('3 days'));

        $this->manager->flush();
    }

    /**
     * @Given the :catalogPromotion catalog promotion has been disabled
     */
    public function theCatalogPromotionHasBeenDisabled(CatalogPromotionInterface $catalogPromotion)
    {
        $catalogPromotion->removeChannel($this->sharedStorage->get('channel'));

        $this->manager->flush();
    }

    /**
     * @Given the :catalogPromotion catalog promotion has been made exclusive
     */
    public function theCatalogPromotionHasBeenMadeExclusive(CatalogPromotionInterface $catalogPromotion)
    {
        $catalogPromotion->setExclusive(true);

        $this->manager->flush();
    }

    /**
     * @Given /^(it) is applicable for ("[^"]*" product)$/
     */
    public function itIsApplicableForProduct(CatalogPromotionInterface $catalogPromotion, ProductInterface $product)
    {
        /** @var CatalogRuleInterface $rule */
        $rule = $this->catalogRulePromotionFactory->createNew();

        $rule->setType(IsProductRuleChecker::TYPE);
        $rule->setConfiguration(['products' => [$product->getCode()]]);

        $catalogPromotion->addRule($rule);

        $this->manager->flush();
    }

    /**
     * @Given /^(it) is applicable for products (classified as "[^"]*")$/
     */
    public function itIsApplicableForProductsClassifiedAs(CatalogPromotionInterface $catalogPromotion, TaxonInterface $taxon)
    {
        /** @var CatalogRuleInterface $rule */
        $rule = $this->catalogRulePromotionFactory->createNew();

        $rule->setType(IsFromTaxonRuleChecker::TYPE);
        $rule->setConfiguration(['taxons' => [$taxon->getCode()]]);

        $catalogPromotion->addRule($rule);

        $this->manager->flush();
    }

    /**
     * @param string $catalogPromotionName
     *
     * @return CatalogPromotionInterface
     */
    private function createPromotion($catalogPromotionName)
    {
        /** @var CatalogPromotionInterface $catalogPromotion */
        $catalogPromotion = $this->catalogPromotionFactory->createNew();

        $catalogPromotion->setName($catalogPromotionName);
        $catalogPromotion->setCode(StringInflector::nameToCode($catalogPromotionName));

        return $catalogPromotion;
    }

    /**
     * @param CatalogPromotionInterface $catalogPromotion
     */
    private function saveCatalogPromotion(CatalogPromotionInterface $catalogPromotion)
    {
        $this->catalogPromotionRepository->add($catalogPromotion);
        $this->sharedStorage->set('catalog_promotion', $catalogPromotion);
    }
}
