<?php

namespace Acme\SyliusCatalogPromotionBundle\OrderProcessing;

use Acme\SyliusCatalogPromotionBundle\Action\CatalogDiscountActionCommandInterface;
use Acme\SyliusCatalogPromotionBundle\Applicator\CatalogPromotionApplicatorInterface;
use Acme\SyliusCatalogPromotionBundle\Entity\CatalogPromotionInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class CatalogPromotionProcessor implements OrderProcessorInterface
{
    /**
     * @var RepositoryInterface
     */
    private $catalogPromotionRepository;

    /**
     * @var ServiceRegistryInterface
     */
    private $serviceRegistry;

    /**
     * @var CatalogPromotionApplicatorInterface
     */
    private $catalogPromotionApplicator;

    /**
     * @param RepositoryInterface $catalogPromotionRepository
     * @param ServiceRegistryInterface $serviceRegistry
     * @param CatalogPromotionApplicatorInterface $catalogPromotionApplicator
     */
    public function __construct(
        RepositoryInterface $catalogPromotionRepository,
        ServiceRegistryInterface $serviceRegistry,
        CatalogPromotionApplicatorInterface $catalogPromotionApplicator
    ) {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
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
            foreach ($this->catalogPromotionRepository->findAll() as $catalogPromotion) {
                /** @var CatalogDiscountActionCommandInterface $command */
                $command = $this->serviceRegistry->get($catalogPromotion->getType());

                $discount = $command->calculate($item, $catalogPromotion->getConfiguration());

                $this->catalogPromotionApplicator->apply($item, $discount, $catalogPromotion->getName());
            }
        }
    }
}
