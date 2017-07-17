<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\ShopApi\ViewFactory;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Sylius\ShopApiPlugin\Factory\ProductVariantViewFactoryInterface;
use Sylius\ShopApiPlugin\View\ProductVariantView as BaseProductVariantView;
use Urbanara\CatalogPromotionPlugin\Action\CatalogDiscountActionCommandInterface;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionDecoration;
use Urbanara\CatalogPromotionPlugin\Provider\CatalogPromotionProviderInterface;
use Urbanara\CatalogPromotionPlugin\ShopApi\View\AppliedPromotionView;
use Urbanara\CatalogPromotionPlugin\ShopApi\View\DecorationView;
use Urbanara\CatalogPromotionPlugin\ShopApi\View\ProductVariantView;
use Webmozart\Assert\Assert;

final class ProductVariantViewFactory implements ProductVariantViewFactoryInterface
{
    /** @var ProductVariantViewFactoryInterface */
    private $decoratedFactory;

    /** @var CatalogPromotionProviderInterface */
    private $catalogPromotionProvider;

    /** @var ServiceRegistryInterface */
    private $serviceRegistry;

    /** @var string */
    private $appliedPromotionViewClass;

    /** @var string */
    private $decorationViewClass;

    public function __construct(
        ProductVariantViewFactoryInterface $decoratedFactory,
        CatalogPromotionProviderInterface $catalogPromotionProvider,
        ServiceRegistryInterface $serviceRegistry,
        string $appliedPromotionViewClass,
        string $decorationViewClass
    ) {
        $this->decoratedFactory = $decoratedFactory;
        $this->catalogPromotionProvider = $catalogPromotionProvider;
        $this->serviceRegistry = $serviceRegistry;
        $this->appliedPromotionViewClass = $appliedPromotionViewClass;
        $this->decorationViewClass = $decorationViewClass;
    }

    public function create(ProductVariantInterface $variant, ChannelInterface $channel, string $locale): BaseProductVariantView
    {
        /** @var ProductVariantView $productVariantView */
        $productVariantView = $this->decoratedFactory->create($variant, $channel, $locale);

        Assert::isInstanceOf($productVariantView, ProductVariantView::class);

        $applicableCatalogPromotions = $this->catalogPromotionProvider->provide($channel, $variant);
        if (count($applicableCatalogPromotions) === 0) {
            return $productVariantView;
        }

        $productVariantView->price->original = $productVariantView->price->current;
        $price = $productVariantView->price->current;

        foreach ($applicableCatalogPromotions as $applicableCatalogPromotion) {
            /** @var CatalogDiscountActionCommandInterface $command */
            $command = $this->serviceRegistry->get($applicableCatalogPromotion->getDiscountType());

            $discount = $command->calculate($price, $channel, $applicableCatalogPromotion->getDiscountConfiguration());

            $price -= $discount;
        }

        $productVariantView->price->current = $price;

        $appliedPromotionViews = [];
        foreach ($applicableCatalogPromotions as $applicableCatalogPromotion) {
            /** @var AppliedPromotionView $appliedPromotionView */
            $appliedPromotionView = new $this->appliedPromotionViewClass();
            $appliedPromotionView->code = $applicableCatalogPromotion->getCode();
            $appliedPromotionView->decorations = array_map(function (CatalogPromotionDecoration $decoration) {
                /** @var DecorationView $decorationView */
                $decorationView = new $this->decorationViewClass();
                $decorationView->type = $decoration->getType();
                $decorationView->configuration = json_encode($decoration->getConfiguration());

                return $decorationView;
            }, iterator_to_array($applicableCatalogPromotion->getDecorations()));

            $appliedPromotionViews[] = $appliedPromotionView;
        }

        $productVariantView->appliedPromotions = $appliedPromotionViews;

        return $productVariantView;
    }
}
