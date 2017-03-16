<?php

namespace Acme\SyliusCatalogPromotionBundle\Form\Type\Action;

use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Range;

final class FixedCatalogDiscountType extends AbstractType
{
    /**
     * @var ChannelRepositoryInterface
     */
    private $channelRepository;

    /**
     * @param ChannelRepositoryInterface $channelRepository
     */
    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('values', null, [
            'label' => 'sylius.form.variant.price',
            'compound' => true,
        ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $form = $event->getForm()->get('values');

            /** @var ChannelInterface[] $channels */
            $channels = $this->channelRepository->findAll();
            foreach ($channels as $channel) {
                $form->add($channel->getCode(), MoneyType::class, [
                    'property_path' => '[' . $channel->getCode() . ']',
                    'required' => false,
                    'block_name' => 'entry',
                    'currency' => $channel->getBaseCurrency()->getCode(),
                    'label' => $channel->getName(),
                    'constraints' => [
                        new Range([
                            'groups' => ['sylius'],
                            'min' => 0,
                            'minMessage' => 'acme_sylius_catalog_promotion.catalog_promotion.configuration.discounts.min',
                        ]),
                    ],
                ]);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'acme_sylius_catalog_promotion_fixed_value_action';
    }
}
