<?php

namespace Tests\Acme\SyliusCatalogPromotionPlugin\Behat\Context\Setup;

use Acme\SyliusCatalogPromotionPlugin\Action\PercentageCatalogDiscountCommand;
use Behat\Behat\Tester\Exception\PendingException;
use Acme\SyliusCatalogPromotionPlugin\Action\FixedCatalogDiscountCommand;
use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Formatter\StringInflector;
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
     * @param RepositoryInterface $catalogPromotionRepository
     * @param ObjectManager $manager
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        FactoryInterface $catalogPromotionFactory,
        RepositoryInterface $catalogPromotionRepository,
        ObjectManager $manager
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->catalogPromotionRepository = $catalogPromotionRepository;
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
     * @Given /^(it) gives ("(?:€|£|\$)[^"]+") discount on every product$/
     */
    public function itGivesDiscountOnEveryProduct(CatalogPromotionInterface $catalogPromotion, $discount)
    {
        $channel = $this->sharedStorage->get('channel');

        $catalogPromotion->addChannel($channel);
        $catalogPromotion->setConfiguration(array_merge($catalogPromotion->getConfiguration(), ['values' => [$channel->getCode() => $discount]]));
        $catalogPromotion->setType(FixedCatalogDiscountCommand::TYPE);

        $this->manager->flush();
    }

    /**
     * @Given /^(it) gives (\d+)% discount on every product$/
     */
    public function itGivesDiscountOnEveryProduct2(CatalogPromotionInterface $catalogPromotion, $discount)
    {
        $catalogPromotion->setConfiguration(array_merge($catalogPromotion->getConfiguration(), ['percentage' => $discount / 100]));
        $catalogPromotion->setType(PercentageCatalogDiscountCommand::TYPE);

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
