<?php

namespace Acme\SyliusCatalogPromotionPlugin\Form\Type\Rule;

use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class IsFromTaxonType extends AbstractType
{
    /**
     * @var DataTransformerInterface
     */
    private $taxonsToCodesTransformer;

    /**
     * @param DataTransformerInterface $taxonsToCodesTransformer
     */
    public function __construct(DataTransformerInterface $taxonsToCodesTransformer)
    {
        $this->taxonsToCodesTransformer = $taxonsToCodesTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taxons', TaxonAutocompleteChoiceType::class, [
                'label' => 'sylius.form.promotion_rule.has_taxon.taxons',
                'multiple' => true,
            ])
        ;

        $builder->get('taxons')->addModelTransformer($this->taxonsToCodesTransformer);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'acme_sylius_catalog_promotion_is_from_taxon_rule';
    }
}
