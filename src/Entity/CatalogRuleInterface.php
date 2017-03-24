<?php

namespace Acme\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface CatalogRuleInterface extends ResourceInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     */
    public function setType($type);

    /**
     * @return array
     */
    public function getConfiguration();

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration);

    /**
     * @return CatalogPromotionInterface
     */
    public function getCatalogPromotion();

    /**
     * @param CatalogPromotionInterface $catalogPromotion
     */
    public function setCatalogPromotion(CatalogPromotionInterface $catalogPromotion = null);
}
