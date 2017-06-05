<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class MenuBuilderListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addCatalogPromotion(MenuBuilderEvent $event)
    {
        $marketingMenu = $this->getMarketingMenu($event);

        $marketingMenu
            ->addChild('catalog_promotion', ['route' => 'urbanara_catalog_promotion_admin_catalog_promotion_index'])
            ->setLabel('urbanara_catalog_promotion.menu.admin.catalog_promotions')
            ->setLabelAttribute('icon', 'in cart')
        ;
    }

    /**
     * @param MenuBuilderEvent $event
     *
     * @return ItemInterface
     */
    private function getMarketingMenu(MenuBuilderEvent $event)
    {
        $adminMenu = $event->getMenu();
        $marketingMenu = $adminMenu->getChild('marketing');

        if (null === $marketingMenu) {
            $marketingMenu = $adminMenu
                ->addChild('marketing')
                ->setLabel('urbanara_catalog_promotion.menu.admin.header')
            ;
        }

        return $marketingMenu;
    }
}
