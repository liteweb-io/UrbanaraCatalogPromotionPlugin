<?php

namespace Urbanara\CatalogPromotionPlugin\Templating\Helper;

use Urbanara\CatalogPromotionPlugin\Action\CatalogDiscountActionCommandInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\Model\CatalogVariantPrice;
use Urbanara\CatalogPromotionPlugin\Provider\CatalogPromotionProviderInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\Templating\Helper\Helper;

final class CatalogPriceHelper extends Helper
{
    /**
     * @var CatalogPromotionProviderInterface
     */
    private $catalogPromotionProvider;

    /**
     * @var ServiceRegistryInterface
     */
    private $serviceRegistry;

    /**
     * @param CatalogPromotionProviderInterface $catalogPromotionProvider
     * @param ServiceRegistryInterface $serviceRegistry
     */
    public function __construct(
        CatalogPromotionProviderInterface $catalogPromotionProvider,
        ServiceRegistryInterface $serviceRegistry
    ) {
        $this->catalogPromotionProvider = $catalogPromotionProvider;
        $this->serviceRegistry = $serviceRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function getCatalogPrice(ProductVariantInterface $variant, array $context)
    {
        $channel = $context['channel'];
        $currentPrice = $variant->getChannelPricingForChannel($channel)->getPrice();
        $discount = 0;

        /** @var CatalogPromotionInterface $catalogPromotion */
        foreach ($this->catalogPromotionProvider->provide($channel, $variant) as $catalogPromotion) {
            /** @var CatalogDiscountActionCommandInterface $command */
            $command = $this->serviceRegistry->get($catalogPromotion->getDiscountType());

            $discount += $command->calculate($currentPrice - $discount, $channel, $catalogPromotion->getDiscountConfiguration());
        }

        return new CatalogVariantPrice($currentPrice, $currentPrice - $discount);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'acme_catalog_price';
    }
}
