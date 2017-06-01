<?php

declare(strict_types=1);

namespace Tests\Urbanara\CatalogPromotionPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class CatalogPromotionContext implements Context
{
    /**
     * @var RepositoryInterface
     */
    private $catalogPromotionRepository;

    /**
     * @param RepositoryInterface $catalogPromotionRepository
     */
    public function __construct(
        RepositoryInterface $catalogPromotionRepository
    ) {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
    }

    /**
     * @Transform :catalogPromotion
     * @Transform /^"([^"]+)" catalog promotion$/
     */
    public function getPromotionByName($catalogPromotionName)
    {
        $catalogPromotion = $this->catalogPromotionRepository->findOneBy(['name' => $catalogPromotionName]);

        Assert::notNull(
            $catalogPromotion,
            sprintf('Catalog promotion with name "%s" does not exist', $catalogPromotionName)
        );

        return $catalogPromotion;
    }
}
