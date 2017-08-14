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
    public function it_shows_paginated_product_list()
    {
        $this->loadFixturesFromFile('search_shop.yml');

        $this->client->request('GET', '/shop-api/products?channel=WEB_GB', [], [], ['ACCEPT' => 'application/json'], '{}');

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'elastic_search/product_list_page', Response::HTTP_OK);
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
