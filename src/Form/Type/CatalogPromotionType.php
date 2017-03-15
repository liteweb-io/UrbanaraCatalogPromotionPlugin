<?php

namespace Acme\SyliusCatalogPromotionBundle\Form\Type;

use Acme\SyliusCatalogPromotionBundle\Action\CatalogDiscountActionCommandInterface;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

final class CatalogPromotionType extends AbstractResourceType
{
    /**
     * @var EventSubscriberInterface
     */
    private $catalogPromotionActionConfigurationSubscriber;

    /**
     * @var ServiceRegistryInterface
     */
    private $registry;

    /**
     * @param string $dataClass FQCN
     * @param string[] $validationGroups
     * @param ServiceRegistryInterface $registry
     * @param EventSubscriberInterface $catalogPromotionActionConfigurationSubscriber
     */
    public function __construct(
        $dataClass,
        array $validationGroups = [],
        ServiceRegistryInterface $registry,
        EventSubscriberInterface $catalogPromotionActionConfigurationSubscriber
    ) {
        parent::__construct($dataClass, $validationGroups);

        $this->catalogPromotionActionConfigurationSubscriber = $catalogPromotionActionConfigurationSubscriber;
        $this->registry = $registry;
    }

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
            ->add('type', CatalogActionChoiceType::class, [
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.type',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.channels',
            ])
            ->addEventSubscriber($this->catalogPromotionActionConfigurationSubscriber)
            ->addEventSubscriber(new AddCodeFormSubscriber())
        ;

        $prototypes = [];

        /** @var CatalogDiscountActionCommandInterface $command */
        foreach ($this->registry->all() as $type => $command) {
            $prototypes[$type] = $builder->create('actions', $command->getConfigurationFormType())->getForm();
        }

        $builder->setAttribute('prototypes', $prototypes);
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
    public function getBlockPrefix()
    {
        return 'acme_sylius_catalog_promotion';
    }
}
