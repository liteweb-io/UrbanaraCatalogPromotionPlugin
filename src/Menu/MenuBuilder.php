<?php

namespace Acme\SyliusCatalogPromotionBundle\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class MenuBuilder
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addCatalogPromotion(MenuBuilderEvent $event)
    {
        $marketingMenu = $this->getMarketingMenu($event);

        $marketingMenu
            ->addChild('catalog_promotion', ['route' => 'acme_sylius_catalog_promotion_admin_catalog_promotion_index'])
            ->setLabel('acme_sylius_catalog_promotion.menu.admin.catalog_promotion')
            ->setLabelAttribute('icon', 'in_cart')
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
                ->setLabel('acme_sylius_catalog_promotion.menu.admin.header')
            ;
        }

        return $marketingMenu;
    }
}
