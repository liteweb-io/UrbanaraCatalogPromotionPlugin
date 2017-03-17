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
     * @Given there is a :catalogPromotionName catalog promotion identified by :catalogPromotionCode code
     */
    public function thereIsACatalogPromotion($catalogPromotionName, $catalogPromotionCode = null)
    {
        /** @var CatalogPromotionInterface $catalogPromotion */
        $catalogPromotion = $this->catalogPromotionFactory->createNew();

        $catalogPromotion->setName($catalogPromotionName);
        $catalogPromotion->setCode($catalogPromotionCode ?: StringInflector::nameToCode($catalogPromotionName));

        $this->catalogPromotionRepository->add($catalogPromotion);
        $this->sharedStorage->set('catalog_promotion', $catalogPromotion);
    }

    /**
     * @Given /^(it) gives ("(?:€|£|\$)[^"]+") discount on every product$/
     */
    public function itGivesDiscountOnEveryProduct(CatalogPromotionInterface $catalogPromotion, $discount)
    {
        $catalogPromotion->setConfiguration(array_merge($catalogPromotion->getConfiguration(), ['values' => [$this->sharedStorage->get('channel')->getCode() => $discount]]));
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
}
