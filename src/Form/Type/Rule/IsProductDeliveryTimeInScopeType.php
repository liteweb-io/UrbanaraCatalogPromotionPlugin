<?php

namespace Urbanara\CatalogPromotionPlugin\Form\Type\Rule;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbanara\CatalogPromotionPlugin\Rule\IsDeliveryTimeInScopeRuleChecker;

final class IsProductDeliveryTimeInScopeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('criteria', ChoiceType::class, [
                'label' => 'urbanara_catalog_promotion.form.catalog_promotion_rule.delivery_time.criteria',
                'choices' => [
                    'sylius.ui.less_than' => IsDeliveryTimeInScopeRuleChecker::CRITERIA_LESS,
                    'sylius.ui.equal' => IsDeliveryTimeInScopeRuleChecker::CRITERIA_EQUAL,
                    'sylius.ui.greater_than' => IsDeliveryTimeInScopeRuleChecker::CRITERIA_MORE,
                ],
            ])
            ->add('weeks', IntegerType::class, [
                'label' => 'urbanara_catalog_promotion.form.catalog_promotion_rule.delivery_time.weeks',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'urbanara_catalog_promotion_is_delivery_time_in_scope_rule';
    }
}
