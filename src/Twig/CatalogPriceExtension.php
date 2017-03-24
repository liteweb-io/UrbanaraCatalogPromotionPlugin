<?php

namespace Acme\SyliusCatalogPromotionPlugin\Twig;

use Symfony\Component\Templating\Helper\Helper;

final class CatalogPriceExtension extends \Twig_Extension
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('acme_catalog_price', [$this->helper, 'getCatalogPrice']),
        ];
    }
}
