<?php

namespace Urbanara\CatalogPromotionPlugin\Form\Type\Action;

use Sylius\Bundle\CoreBundle\Form\Type\ChannelCollectionType;
use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Sylius\Component\Core\Model\ChannelInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;

final class FixedCatalogDiscountType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('values', ChannelCollectionType::class, [
            'label' => 'sylius.form.variant.price',
            'entry_type' => MoneyType::class,
            'entry_options' => function (ChannelInterface $channel) {
                return [
                    'label' => $channel->getName(),
                    'currency' => $channel->getBaseCurrency()->getCode(),
                    'required' => false,
                    'constraints' => [
                        new GreaterThan([
                            'groups' => ['sylius'],
                            'value' => 0,
                            'message' => 'urbanara_catalog_promotion.catalog_promotion.configuration.discounts.min',
                        ]),
                    ],
                ];
            },
            'required' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'urbanara_catalog_promotion_fixed_value_action';
    }
}
