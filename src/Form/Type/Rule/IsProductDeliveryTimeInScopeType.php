<?php

namespace Urbanara\CatalogPromotionPlugin\Form\Type\Rule;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbanara\CatalogPromotionPlugin\Rule\IsDeliveryTimeInScopeRuleChecker;

final class IsProductDeliveryTimeInScopeType extends AbstractType
{
    const LABEL_DELIVERY_TIME_CRITERIA = 'urbanara_catalog_promotion.form.catalog_promotion_rule.delivery_time.criteria';
    const LABEL_DELIVERY_TIME_WEEKS = 'urbanara_catalog_promotion.form.catalog_promotion_rule.delivery_time.weeks';
    const BLOCK_PREFIX = 'urbanara_catalog_promotion_is_delivery_time_in_scope_rule';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('criteria', ChoiceType::class, [
                'label' => self::LABEL_DELIVERY_TIME_CRITERIA,
                'choices' => [
                    'sylius.ui.less_than' => IsDeliveryTimeInScopeRuleChecker::CRITERIA_LESS,
                    'sylius.ui.equal' => IsDeliveryTimeInScopeRuleChecker::CRITERIA_EQUAL,
                    'sylius.ui.greater_than' => IsDeliveryTimeInScopeRuleChecker::CRITERIA_MORE,
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
