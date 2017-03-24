# Urbanara Catalog Promotion Plugin [![License](https://img.shields.io/packagist/l/sylius/bundle-skeleton.svg)](https://packagist.org/packages/sylius/bundle-skeleton) [![Version](https://img.shields.io/packagist/v/sylius/bundle-skeleton.svg)](https://packagist.org/packages/sylius/bundle-skeleton) [![Build status on Linux](https://img.shields.io/travis/Sylius/BundleSkeleton/master.svg)](http://travis-ci.org/Sylius/BundleSkeleton) [![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/Sylius/BundleSkeleton.svg)](https://scrutinizer-ci.com/g/Sylius/BundleSkeleton/)

Plugin provides basic functionality of catalog promotion on a top of [Sylius platform](https://github.com/Sylius/Sylius)

## Installation

1. Add plugin to your vendors:
```bash
$ composer require urbanara/catalog-promotion-plugin
```
2. Extend config files:
    1. Import project config: 
        ```yml
        # app/config/config.yml

        imports:
            ...
            - { resource: "@CatalogPromotionPlugin/Resources/config/app/grid.yml" }
        ```
    2. Import project routing: 
        ```yml
        # app/config/routing.yml
        ...

        urbanara_catalog_plugin:
            resource: "@CatalogPromotionPlugin/Resources/config/routing.yml"
            prefix: /admin
        ```
    3. Add plugin to AppKernel: 
        ```php

        // app/AppKernel.php

        $bundles = [
           ...
            new \Urbanara\CatalogPromotionPlugin\SyliusCatalogPromotionPlugin(),
        ];

        ```
    4. Extend gulp file with following script:
        ```js
        // Gulpfile.js
 
        gulp.task('catalog-promotion', function() {
            return gulp.src([
                'node_modules/jquery/dist/jquery.min.js',
                'vendor/sylius/sylius/src/Sylius/Bundle/UiBundle/Resources/private/js/sylius-prototype-handler.js',
                'vendor/sylius/sylius/src/Sylius/Bundle/UiBundle/Resources/private/js/sylius-form-collection.js',
                'vendor/urbanara/catalog-promotion-plugin/src/Resources/public/**'
            ])
                .pipe(concat('app.js'))
                .pipe(sourcemaps.write('./'))
                .pipe(gulp.dest('web/assets/catalog/' + 'js/'))
                ;
        });
        
        gulp.task('default', ['admin', 'shop', 'catalog-promotion']);
        ```

3. If you want to see strikeout prices in your shop you need to customize templates on your own. A sample customization is available under `tests/Application/app/Resources/SyliusShopBundle`

## Usage

Plugin provides basic crud functionality for catalog promotion as well as processor which will influence unit price of bought items. 
In addition, a twig helper is provided, which will return a ValueObject with old and current price. 

Plugin supports catalog promotion with start date, ends date, promotion prioritization, custom promotion per channel, exclusive promotions.
By default plugin provides two rules which will reduce a number of influenced items and two action.
Rules:
 * Is product - the promotion will be applied only to the products selected in select box.
 * Is from taxon - the promotion will be applied only to the products which has at least one taxon from selected taxons in select box.

Actions:
 * Fixed value action - will reduce the price of product by fixed value. Value is set per channel.
 * Percentage action - will reduce the price of product by a percentage.

All features are described in `features/` section. 
