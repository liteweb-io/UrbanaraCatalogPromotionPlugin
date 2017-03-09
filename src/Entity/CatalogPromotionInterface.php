<?php

namespace Acme\SyliusCatalogPromotionBundle\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface CatalogPromotionInterface extends TimestampableInterface, ResourceInterface
{
    /**
     * @param mixed $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getCode();

    /**
     * @param string $code
     */
    public function setCode($code);

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
}
