<?php

namespace Urbanara\CatalogPromotionPlugin\Entity;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
class CatalogPromotionDecoration implements CatalogPromotionDecorationInterface
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
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function setCatalogPromotion(?CatalogPromotionInterface $catalogPromotion): void
    {
        $this->catalogPromotion = $catalogPromotion;
    }

    /**
     * {@inheritdoc}
     */
    public function getCatalogPromotion(): ?CatalogPromotionInterface
    {
        return $this->catalogPromotion;
    }
}
