<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\ElasticSearch\Factory;

use ONGR\FilterManagerBundle\Search\SearchResponse;
use Sylius\ElasticSearchPlugin\Controller\ProductListView;
use Sylius\ElasticSearchPlugin\Factory\ProductListViewFactoryInterface;
use Urbanara\CatalogPromotionPlugin\ElasticSearch\Controller\DecorationView;
use Urbanara\CatalogPromotionPlugin\ElasticSearch\Controller\PriceView;
use Urbanara\CatalogPromotionPlugin\ElasticSearch\Controller\VariantView;
use Urbanara\CatalogPromotionPlugin\ElasticSearch\Document\DecorationDocument;
use Urbanara\CatalogPromotionPlugin\ElasticSearch\Document\ProductDocument;

final class ProductListViewFactory implements ProductListViewFactoryInterface
{
    /** @var ProductListViewFactoryInterface */
    private $decoratedFactory;

    /** @var string */
    private $priceViewClass;

    /** @var string */
    private $decorationViewClass;

    public function __construct(ProductListViewFactoryInterface $decoratedFactory, $priceViewClass, $decorationViewClass)
    {
        $this->decoratedFactory = $decoratedFactory;
        $this->priceViewClass = $priceViewClass;
        $this->decorationViewClass = $decorationViewClass;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromSearchResponse(SearchResponse $response)
    {
        /** @var ProductListView $productListView */
        $productListView = $this->decoratedFactory->createFromSearchResponse($response);

        /** @var ProductDocument $productDocument */
        foreach ($response->getResult() as $productDocument) {
            foreach ($productListView->items as $productView) {
                if ($productView->code !== $productDocument->getCode()) {
                    continue;
                }

                /** @var VariantView $variantView */
                $variantView = current($productView->variants);

                /** @var PriceView $priceView */
                $priceView = $variantView->price;
                $priceView->original = $productDocument->getOriginalPrice() ? $productDocument->getOriginalPrice()->getAmount() : null;

                $variantView->decorations = array_map(function (DecorationDocument $decorationDocument) {
                    /** @var DecorationView $decorationView */
                    $decorationView = new $this->decorationViewClass();
                    $decorationView->type = $decorationDocument->getType();
                    $decorationView->configuration = json_decode($decorationDocument->getConfiguration(), true) ?: [];

                    return $decorationView;
                }, iterator_to_array($productDocument->getDecorations()));
            }
        }

        return $productListView;
    }
}
