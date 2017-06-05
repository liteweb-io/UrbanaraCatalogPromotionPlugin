<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Validator;

use Urbanara\CatalogPromotionPlugin\Action\FixedCatalogDiscountCommand;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\Validator\Constraints\CatalogPromotionDiscountForEnabledChannel;
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

        if ($value->getDiscountType() !== FixedCatalogDiscountCommand::TYPE) {
            return;
        }

        $channels = $value->getChannels();

        foreach ($channels as $channel) {
            if (!isset($value->getDiscountConfiguration()['values'][$channel->getCode()])) {
                $this->context->buildViolation($constraint->message)
                    ->atPath(sprintf('discountConfiguration[values][%s]', $channel->getCode()))
                    ->addViolation()
                ;

                return;
            }
        }
    }
}
