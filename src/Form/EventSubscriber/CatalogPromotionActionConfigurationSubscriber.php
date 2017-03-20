<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\SyliusCatalogPromotionPlugin\Form\EventSubscriber;

use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Webmozart\Assert\Assert;

final class CatalogPromotionActionConfigurationSubscriber implements EventSubscriberInterface
{
    /**
     * @var ServiceRegistryInterface
     */
    private $registry;

    /**
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * @param ServiceRegistryInterface $registry
     * @param FormFactoryInterface $factory
     */
    public function __construct(
        ServiceRegistryInterface $registry,
        FormFactoryInterface $factory
    ) {
        $this->registry = $registry;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        /** @var CatalogPromotionInterface $catalogPromotion */
        $catalogPromotion = $event->getData();

        Assert::isInstanceOf($catalogPromotion, CatalogPromotionInterface::class);

        if (null === $discountType = $this->getRegistryIdentifier($catalogPromotion)) {
            return;
        }

        $this->addConfigurationFields($event->getForm(), $discountType, $catalogPromotion->getDiscountConfiguration());
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if (empty($data) || !array_key_exists('discountType', $data)) {
            return;
        }

        $this->addConfigurationFields($event->getForm(), $data['discountType']);
    }

    /**
     * @param FormInterface $form
     * @param string $registryIdentifier
     * @param array $data
     */
    private function addConfigurationFields(FormInterface $form, $registryIdentifier, array $data = [])
    {
        // FIXME: Unknown discountType of $model, may crash in any moment!
        $model = $this->registry->get($registryIdentifier);

        if (null === $configuration = $model->getConfigurationFormType()) {
            return;
        }

        $configurationField = $this->factory->createNamed(
            'discountConfiguration',
            $configuration,
            $data,
            [
                'auto_initialize' => false,
                'label' => false,
            ]
        );

        $form->add($configurationField);
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
