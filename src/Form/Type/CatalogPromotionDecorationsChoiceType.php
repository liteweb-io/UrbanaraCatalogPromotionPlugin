<?php

namespace Urbanara\CatalogPromotionPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CatalogPromotionDecorationsChoiceType extends AbstractType
{
    /**
     * @var array
     */
    private $promotionDecorations;

    /**
     * @param array $promotionDecorations
     */
    public function __construct(array $promotionDecorations)
    {
        $this->promotionDecorations = $promotionDecorations;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'choices' => array_flip($this->promotionDecorations),
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'urbanara_catalog_promotion_catalog_promotion_decoration_choices';
    }
}
