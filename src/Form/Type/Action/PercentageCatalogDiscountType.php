<?php

namespace Acme\SyliusCatalogPromotionPlugin\Form\Type\Action;

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
                'data' => 0,
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.percentage',
                'constraints' => [
                    new Range([
                        'groups' => ['sylius'],
                        'min' => 0,
                        'minMessage' => 'acme_sylius_catalog_promotion.catalog_promotion.percentage.min',
                        'max' => 100,
                        'maxMessage' => 'acme_sylius_catalog_promotion.catalog_promotion.percentage.max',
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
        return 'acme_sylius_catalog_promotion_percentage_action';
    }
}
