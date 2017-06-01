<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Form\Type\Decoration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class BannerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class, [
                'label' => 'urbanara_catalog_promotion.form.catalog_promotion_decoration.banner.url',
            ])
            ->add('position', ChoiceType::class, [
                'choices' => [
                    'urbanara_catalog_promotion.form.catalog_promotion_decoration.banner.position.top_right' => 'top-right',
                    'urbanara_catalog_promotion.form.catalog_promotion_decoration.banner.position.top' => 'top',
                    'urbanara_catalog_promotion.form.catalog_promotion_decoration.banner.position.top_left' => 'top-left',
                    'urbanara_catalog_promotion.form.catalog_promotion_decoration.banner.position.right' => 'right',
                    'urbanara_catalog_promotion.form.catalog_promotion_decoration.banner.position.center' => 'center',
                    'urbanara_catalog_promotion.form.catalog_promotion_decoration.banner.position.left' => 'left',
                    'urbanara_catalog_promotion.form.catalog_promotion_decoration.banner.position.bottom_right' => 'bottom-right',
                    'urbanara_catalog_promotion.form.catalog_promotion_decoration.banner.position.bottom' => 'bottom',
                    'urbanara_catalog_promotion.form.catalog_promotion_decoration.banner.position.bottom_left' => 'bottom-left',
                ],
            ])
            ->add('activeOnProductDisplayPage', CheckboxType::class, [
                'label' => 'urbanara_catalog_promotion.form.catalog_promotion_decoration.active_on_product_display_page',
                'required' => false,
            ])
            ->add('activeOnProductListingPage', CheckboxType::class, [
                'label' => 'urbanara_catalog_promotion.form.catalog_promotion_decoration.active_on_product_listing_page',
                'required' => false,
            ])
            ->add('activeOnCheckoutPage', CheckboxType::class, [
                'label' => 'urbanara_catalog_promotion.form.catalog_promotion_decoration.active_on_checkout_page',
                'required' => false,
            ])
        ;
    }
}
