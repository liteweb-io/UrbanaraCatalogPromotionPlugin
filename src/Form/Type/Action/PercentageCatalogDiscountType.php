<?php

namespace Urbanara\CatalogPromotionPlugin\Form\Type\Action;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;

final class PercentageCatalogDiscountType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('percentage', PercentType::class, [
                'label' => 'urbanara_catalog_promotion.form.catalog_promotion.percentage',
                'constraints' => [
                    new Range([
                        'groups' => ['sylius'],
                        'min' => 0,
                        'minMessage' => 'urbanara_catalog_promotion.catalog_promotion.percentage.min',
                        'max' => 100,
                        'maxMessage' => 'urbanara_catalog_promotion.catalog_promotion.percentage.max',
                    ]),
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'urbanara_catalog_promotion_percentage_action';
    }
}
