<?php

namespace Tests\Acme\SyliusCatalogPromotionBundle\Behat\Page\Admin;

use Sylius\Behat\Behaviour\NamesIt;
use Sylius\Behat\Behaviour\SpecifiesItsCode;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use NamesIt;
    use SpecifiesItsCode;

    public function makeExclusive()
    {
        $this->getDocument()->checkField('Exclusive');
    }

    /**
     * {@inheritdoc}
     */
    public function setStartsAt(\DateTime $dateTime)
    {
        $timestamp = $dateTime->getTimestamp();

        $this->getDocument()->fillField('acme_sylius_catalog_promotion_startsAt_date', date('Y-m-d', $timestamp));
        $this->getDocument()->fillField('acme_sylius_catalog_promotion_startsAt_time', date('H:i', $timestamp));
    }

    /**
     * {@inheritdoc}
     */
    public function setEndsAt(\DateTime $dateTime)
    {
        $timestamp = $dateTime->getTimestamp();

        $this->getDocument()->fillField('acme_sylius_catalog_promotion_endsAt_date', date('Y-m-d', $timestamp));
        $this->getDocument()->fillField('acme_sylius_catalog_promotion_endsAt_time', date('H:i', $timestamp));
    }
}
