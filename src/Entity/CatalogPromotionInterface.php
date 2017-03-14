<?php

namespace Acme\SyliusCatalogPromotionBundle\Entity;

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
    public function getExclusive();

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
    public function getType();

    /**
     * @param string $type
     */
    public function setType($type);

    /**
     * @return array
     */
    public function getConfiguration();

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration);
}
