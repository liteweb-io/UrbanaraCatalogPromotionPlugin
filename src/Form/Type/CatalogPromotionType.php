<?php

namespace Acme\SyliusCatalogPromotionBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class CatalogPromotionType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.name',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.description',
                'required' => false,
            ])
            ->add('exclusive', CheckboxType::class, [
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.exclusive',
            ])
            ->add('startsAt', DateTimeType::class, [
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.starts_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
            ])
            ->add('endsAt', DateTimeType::class, [
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.ends_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
            ])
            ->addEventSubscriber(new AddCodeFormSubscriber())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'acme_sylius_catalog_promotion';
    }
}
