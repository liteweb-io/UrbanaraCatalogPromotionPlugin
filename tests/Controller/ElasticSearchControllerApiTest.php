<?php

declare(strict_types=1);

namespace Tests\Sylius\UrbanaraCatalogPromotionPlugin\Controller;

use Lakion\ApiTestCase\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class ElasticSearchControllerApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_shows_paginated_product_list_in_en_US_locale()
    {
        $this->loadFixturesFromFile('search_shop.yml');

        $this->client->request('GET', '/shop-api/products?channel=WEB_GB&locale=en_US', [], [], ['ACCEPT' => 'application/json'], '{}');

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'elastic_search/en_US/product_list_page', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_paginated_product_list_in_de_DE_locale()
    {
        $this->loadFixturesFromFile('search_shop.yml');

        $this->client->request('GET', '/shop-api/products?channel=WEB_GB&locale=de_DE', [], [], ['ACCEPT' => 'application/json'], '{}');

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'elastic_search/de_DE/product_list_page', Response::HTTP_OK);
    }

    /**
     * @before
     */
    protected function purgeElasticSearch()
    {
        $elasticSearchManager = static::$sharedKernel->getContainer()->get('es.manager.default');
        $elasticSearchManager->dropAndCreateIndex();
    }
}
