<?php

namespace Acme\SyliusCatalogPromotionPlugin\Form\Type\Rule;

use Mockery\Matcher\Type;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class IsProductType extends AbstractType
{
    /**
     * @var DataTransformerInterface
     */
    private $productsToCodesTransformer;

    /**
     * @param DataTransformerInterface $productsToCodesTransformer
     */
    public function __construct(DataTransformerInterface $productsToCodesTransformer)
    {
        $this->productsToCodesTransformer = $productsToCodesTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('products', ResourceAutocompleteChoiceType::class, [
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion_rule.products',
                'resource' => 'sylius.product',
                'choice_name' => 'name',
                'multiple' => true,
                'choice_value' => 'code',
            ])
        ;

        $builder->get('products')->addModelTransformer($this->productsToCodesTransformer);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'acme_sylius_catalog_promotion_is_product_rule';
    }
}
