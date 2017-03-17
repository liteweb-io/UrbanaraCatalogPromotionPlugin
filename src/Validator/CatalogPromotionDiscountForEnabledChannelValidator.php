<?php

namespace Acme\SyliusCatalogPromotionPlugin\Validator;

use Acme\SyliusCatalogPromotionPlugin\Action\FixedCatalogDiscountCommand;
use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Acme\SyliusCatalogPromotionPlugin\Validator\Constraints\CatalogPromotionDiscountForEnabledChannel;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

final class CatalogPromotionDiscountForEnabledChannelValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        /** @var CatalogPromotionInterface $value */
        Assert::isInstanceOf($value, CatalogPromotionInterface::class);

        /** @var CatalogPromotionDiscountForEnabledChannel $constraint */
        Assert::isInstanceOf($constraint, CatalogPromotionDiscountForEnabledChannel::class);

        if ($value->getType() !== FixedCatalogDiscountCommand::TYPE) {
            return;
        }

        $channels = $value->getChannels();

        foreach ($channels as $channel) {
            if (!isset($value->getConfiguration()['values'][$channel->getCode()])) {
                $this->context->buildViolation($constraint->message)
                    ->atPath(sprintf('configuration[values][%s]', $channel->getCode()))
                    ->addViolation()
                ;

                return;
            }
        }
    }
}
