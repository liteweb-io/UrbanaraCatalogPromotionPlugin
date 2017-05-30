<?php

namespace Urbanara\CatalogPromotionPlugin\Form\Type;

use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CatalogPromotionDecorationCollectionType extends AbstractType
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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $prototypes = [];

        foreach (array_keys($this->promotionDecorations) as $type) {
            $formBuilder = $builder->create(
                $options['prototype_name'],
                $options['entry_type'],
                array_replace(
                    $options['entry_options'],
                    ['configuration_type' => $type]
                )
            );

            $prototypes[$type] = $formBuilder->getForm();
        }

        $builder->setAttribute('prototypes', $prototypes);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('entry_type', CatalogPromotionDecorationType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['prototypes'] = [];

        foreach ($form->getConfig()->getAttribute('prototypes') as $type => $prototype) {
            /* @var FormInterface $prototype */
            $view->vars['prototypes'][$type] = $prototype->createView($view);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return CollectionType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'urbanara_catalog_promotion_promotion_decoration_collection';
    }
}
