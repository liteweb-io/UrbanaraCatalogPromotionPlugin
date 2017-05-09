<?php

namespace Urbanara\CatalogPromotionPlugin\Form\Type\Rule;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class IsProductSkuType extends AbstractType
{
    const BLOCK_PREFIX = 'urbanara_catalog_promotion_is_product_sku_rule';
    const FORM_TEXTAREA_LABEL = 'urbanara_catalog_promotion.form.catalog_promotion_rule.product_sku_list';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('product_sku_list', TextareaType::class, ['label' => self::FORM_TEXTAREA_LABEL]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return self::BLOCK_PREFIX;
    }
}
