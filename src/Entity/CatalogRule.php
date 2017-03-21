<?php

namespace Acme\SyliusCatalogPromotionPlugin\Entity;

class CatalogRule implements CatalogRuleInterface
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * @var CatalogPromotionInterface
     */
    protected $catalogPromotion;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getCatalogPromotion()
    {
        return $this->catalogPromotion;
    }

    /**
     * {@inheritdoc}
     */
    public function setCatalogPromotion(CatalogPromotionInterface $catalogPromotion = null)
    {
        $this->catalogPromotion = $catalogPromotion;
    }
}
