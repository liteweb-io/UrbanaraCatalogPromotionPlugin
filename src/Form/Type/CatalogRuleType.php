<?php

namespace Acme\SyliusCatalogPromotionPlugin\Form\Type;

use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogRuleInterface;
use Acme\SyliusCatalogPromotionPlugin\Rule\RuleCheckerInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

final class CatalogRuleType extends AbstractResourceType
{
    /**
     * @var ServiceRegistryInterface
     */
    private $ruleRegistry;

    /**
     * @param string $dataClass FQCN
     * @param string[] $validationGroups
     * @param ServiceRegistryInterface $ruleRegistry
     */
    public function __construct($dataClass, array $validationGroups = [], ServiceRegistryInterface $ruleRegistry)
    {
        parent::__construct($dataClass, $validationGroups);

        $this->ruleRegistry = $ruleRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('type', CatalogRulesChoiceType::class, [
                'label' => 'acme_sylius_catalog_promotion.form.catalog_promotion_rule.type',
                'attr' => [
                    'data-form-collection' => 'update',
                ],
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
                $type = $this->getRegistryIdentifier($event->getData());
                if (null === $type) {
                    return;
                }

                $this->addConfigurationFields($event->getForm(), $this->ruleRegistry->get($type));
            })
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                $type = $this->getRegistryIdentifier($event->getData());
                if (null === $type) {
                    return;
                }

                $event->getForm()->get('type')->setData($type);
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
                $data = $event->getData();

                if (!isset($data['type'])) {
                    return;
                }

                $this->addConfigurationFields($event->getForm(), $this->ruleRegistry->get($data['type']));
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'acme_sylius_catalog_promotion_catalog_promotion_rule';
    }

    /**
     * @param FormInterface $form
     * @param RuleCheckerInterface $ruleChecker
     */
    private function addConfigurationFields(FormInterface $form, RuleCheckerInterface $ruleChecker = null)
    {
        $form->add('configuration', $ruleChecker->getConfigurationFormType(), [
            'label' => false,
        ]);
    }

    /**
     * @param CatalogRuleInterface|null $ruleChecker
     *
     * @return null|string
     */
    private function getRegistryIdentifier(CatalogRuleInterface $ruleChecker = null)
    {
        if (null !== $ruleChecker) {
            return $ruleChecker->getType();
        }

        return empty($this->ruleRegistry->all())? null : array_keys($this->ruleRegistry->all())[0];
    }
}
