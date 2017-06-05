<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Registry\FormTypeRegistryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

final class CatalogPromotionDecorationType extends AbstractConfigurableElementType
{
    /**
     * @var array
     */
    private $decorationsTypeToLabel;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        $dataClass,
        array $validationGroups = [],
        FormTypeRegistryInterface $formTypeRegistry,
        array $decorationTypeToLabel
    ) {
        parent::__construct($dataClass, $validationGroups, $formTypeRegistry);

        $this->decorationsTypeToLabel = $decorationTypeToLabel;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('type', CatalogPromotionDecorationsChoiceType::class, [
                'label' => 'urbanara_catalog_promotion.form.catalog_promotion_decoration.type',
                'attr' => [
                    'data-form-collection' => 'update',
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRegistryIdentifier(FormInterface $form, $data = null)
    {
        $registryIdentifier = parent::getRegistryIdentifier($form, $data);

        if (null !== $registryIdentifier) {
            return $registryIdentifier;
        }

        return key($this->decorationsTypeToLabel);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'urbanara_catalog_promotion_catalog_promotion_decoration';
    }
}
