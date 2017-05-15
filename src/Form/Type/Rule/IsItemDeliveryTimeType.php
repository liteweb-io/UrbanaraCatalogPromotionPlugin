<?php

namespace Urbanara\CatalogPromotionPlugin\Form\Type\Rule;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbanara\CatalogPromotionPlugin\Rule\IsItemDeliveryTimeRuleChecker;

final class IsItemDeliveryTimeType extends AbstractType
{
    const LABEL_DELIVERY_TIME_CRITERIA = 'urbanara_catalog_promotion.form.catalog_promotion_rule.delivery_time.criteria';
    const LABEL_DELIVERY_TIME_WEEKS = 'urbanara_catalog_promotion.form.catalog_promotion_rule.delivery_time.weeks';
    const BLOCK_PREFIX = 'urbanara_catalog_promotion_is_delivery_time_in_scope_rule';
    const FORM_TYPE_DROPDOWN_OPTION = 'is_item_delivery_time';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('criteria', ChoiceType::class, [
                'label' => self::LABEL_DELIVERY_TIME_CRITERIA,
                'choices' => [
                    'sylius.ui.less_than' => IsItemDeliveryTimeRuleChecker::CRITERIA_LESS,
                    'sylius.ui.equal' => IsItemDeliveryTimeRuleChecker::CRITERIA_EQUAL,
                    'sylius.ui.greater_than' => IsItemDeliveryTimeRuleChecker::CRITERIA_MORE,
                ],
            ])
            ->add('weeks', IntegerType::class, [
                'label' => self::LABEL_DELIVERY_TIME_WEEKS,
                'required' => true,
                'attr' => ['min' => 1],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return self::BLOCK_PREFIX;
    }
}
