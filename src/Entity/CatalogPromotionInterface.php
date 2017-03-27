<?php

namespace Urbanara\CatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface CatalogPromotionInterface extends TimestampableInterface, ResourceInterface, CodeAwareInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     */
    public function setDescription($description);

    /**
     * @return bool
     */
    public function isExclusive();

    /**
     * @param bool $exclusive
     */
    public function setExclusive($exclusive);

    /**
     * @return \DateTime
     */
    public function getStartsAt();

    /**
     * @param \DateTime $startsAt
     */
    public function setStartsAt(\DateTime $startsAt = null);

    /**
     * @return \DateTime
     */
    public function getEndsAt();

    /**
     * @param \DateTime $endsAt
     */
    public function setEndsAt(\DateTime $endsAt = null);
    /**
     * @return string
     */
    public function getDiscountType();

    /**
     * @param string $type
     */
    public function setDiscountType($type);

    /**
     * @return array
     */
    public function getDiscountConfiguration();

    /**
     * @param array $configuration
     */
    public function setDiscountConfiguration(array $configuration);

    /**
     * @return ChannelInterface[]|Collection
     */
    public function getChannels();

    /**
     * {@inheritdoc}
     */
    public function addChannel(ChannelInterface $channel);

    /**
     * {@inheritdoc}
     */
    public function removeChannel(ChannelInterface $channel);

    /**
     * {@inheritdoc}
     */
    public function hasChannel(ChannelInterface $channel);

    /**
     * @return int
     */
    public function getPriority();

    /**
     * @param int $priority
     */
    public function setPriority($priority);

    /**
     * @return Collection|CatalogRuleInterface[]
     */
    public function getRules();

    /**
     * @return bool
     */
    public function hasRules();

    /**
     * @param CatalogRuleInterface $rule
     *
     * @return bool
     */
    public function hasRule(CatalogRuleInterface $rule);

    /**
     * @param CatalogRuleInterface $rule
     */
    public function addRule(CatalogRuleInterface $rule);

    /**
     * @param CatalogRuleInterface $rule
     */
    public function removeRule(CatalogRuleInterface $rule);
}
