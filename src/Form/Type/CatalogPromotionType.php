<?php

namespace Acme\SyliusCatalogPromotionPlugin\Form\Type;

use Acme\SyliusCatalogPromotionPlugin\Action\CatalogDiscountActionCommandInterface;
use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

final class CatalogPromotionType extends AbstractResourceType
{
    /**
     * @var ServiceRegistryInterface
     */
    private $registry;

    /**
     * @param string $dataClass FQCN
     * @param string[] $validationGroups
     * @param ServiceRegistryInterface $registry
     */
    public function __construct(
        $dataClass,
        array $validationGroups = [],
        ServiceRegistryInterface $registry
    ) {
        parent::__construct($dataClass, $validationGroups);

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
            ->add('priority', IntegerType::class, [
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.priority',
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
            ->add('discountType', CatalogActionChoiceType::class, [
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.type',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.channels',
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
                /** @var CatalogPromotionInterface $catalogPromotion */
                $catalogPromotion = $event->getData();

                $discountType = $this->getRegistryIdentifier($catalogPromotion);
                if (null === $discountType) {
                    return;
                }

                $this->addConfigurationFields($event->getForm(), $this->registry->get($discountType));
            })
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                $type = $this->getRegistryIdentifier($event->getData());
                if (null === $type) {
                    return;
                }

                $event->getForm()->get('discountType')->setData($type);
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
                $data = $event->getData();
                if (empty($data) || !array_key_exists('discountType', $data)) {
                    return;
                }

                $this->addConfigurationFields($event->getForm(), $this->registry->get($data['discountType']));
            })
            ->add('rules', CatalogRuleCollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'error_bubbling' => false,
                'button_add_label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.add_rule',
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion.rules',
            ])
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

    /**
     * @param FormInterface $form
     * @param CatalogDiscountActionCommandInterface $command
     */
    private function addConfigurationFields(FormInterface $form, CatalogDiscountActionCommandInterface $command)
    {
        $form->add('discountConfiguration', $command->getConfigurationFormType(), [
            'label' => false,
        ]);
    }

    /**
     * @param CatalogPromotionInterface|null $catalogPromotion
     *
     * @return null|string
     */
    private function getRegistryIdentifier(CatalogPromotionInterface $catalogPromotion)
    {
        if (null !== $catalogPromotion->getDiscountType()) {
            return $catalogPromotion->getDiscountType();
        }

        return empty($this->registry->all())? null : array_keys($this->registry->all())[0];
    }
}
