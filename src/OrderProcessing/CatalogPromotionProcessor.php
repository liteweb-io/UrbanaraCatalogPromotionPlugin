<?php

namespace Acme\SyliusCatalogPromotionPlugin\OrderProcessing;

use Acme\SyliusCatalogPromotionPlugin\Action\CatalogDiscountActionCommandInterface;
use Acme\SyliusCatalogPromotionPlugin\Applicator\CatalogPromotionApplicatorInterface;
use Acme\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Acme\SyliusCatalogPromotionPlugin\Provider\CatalogPromotionProviderInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class CatalogPromotionProcessor implements OrderProcessorInterface
{
    /**
     * @var CatalogPromotionProviderInterface
     */
    private $catalogPromotionProvider;

    /**
     * @var ServiceRegistryInterface
     */
    private $serviceRegistry;

    /**
     * @var CatalogPromotionApplicatorInterface
     */
    private $catalogPromotionApplicator;

    /**
     * @param CatalogPromotionProviderInterface $catalogPromotionProvider
     * @param ServiceRegistryInterface $serviceRegistry
     * @param CatalogPromotionApplicatorInterface $catalogPromotionApplicator
     */
    public function __construct(
        CatalogPromotionProviderInterface $catalogPromotionProvider,
        ServiceRegistryInterface $serviceRegistry,
        CatalogPromotionApplicatorInterface $catalogPromotionApplicator
    ) {
        $this->catalogPromotionProvider = $catalogPromotionProvider;
        $this->serviceRegistry = $serviceRegistry;
        $this->catalogPromotionApplicator = $catalogPromotionApplicator;
    }

    /**
     * {@inheritdoc}
     */
    public function process(BaseOrderInterface $order)
    {
        /** @var OrderInterface $order */
        Assert::isInstanceOf($order, OrderInterface::class);

        foreach ($order->getItems() as $item) {
            if ($item->isImmutable()) {
                continue;
            }

            /** @var CatalogPromotionInterface $catalogPromotion */
            foreach ($this->catalogPromotionProvider->provide($order->getChannel(), $item) as $catalogPromotion) {
                /** @var CatalogDiscountActionCommandInterface $command */
                $command = $this->serviceRegistry->get($catalogPromotion->getDiscountType());

                $discount = $command->calculate($item, $catalogPromotion->getDiscountConfiguration());

                $this->catalogPromotionApplicator->apply($item, $discount, $catalogPromotion->getName());
            }
        }
    }
}
