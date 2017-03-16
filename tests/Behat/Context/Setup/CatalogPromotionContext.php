<?php

namespace Tests\Acme\SyliusCatalogPromotionBundle\Behat\Context\Setup;

use Acme\SyliusCatalogPromotionBundle\Entity\CatalogPromotionInterface;
use Behat\Behat\Context\Context;
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
     * @param SharedStorageInterface $sharedStorage
     * @param FactoryInterface $catalogPromotionFactory
     * @param RepositoryInterface $catalogPromotionRepository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        FactoryInterface $catalogPromotionFactory,
        RepositoryInterface $catalogPromotionRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->catalogPromotionRepository = $catalogPromotionRepository;
        $this->catalogPromotionFactory = $catalogPromotionFactory;
    }

    /**
     */
    public function thereIsACatalogPromotionIdentifiedByCode($arg1, $arg2)
    {
        throw new PendingException();
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
}
