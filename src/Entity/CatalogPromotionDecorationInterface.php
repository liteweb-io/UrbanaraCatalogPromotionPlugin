<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
interface CatalogPromotionDecorationInterface extends ResourceInterface
{
    /**
     * @param string $type
     */
    public function setType(string $type);

    /**
     * @return string|null
     */
    public function getType();

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration);

    /**
     * @return array
     */
    public function getConfiguration(): array;

    /**
     * @param CatalogPromotionInterface|null $catalogPromotion
     */
    public function setCatalogPromotion(CatalogPromotionInterface $catalogPromotion = null);

    /**
     * @return CatalogPromotionInterface|null
     */
    public function getCatalogPromotion();
}
