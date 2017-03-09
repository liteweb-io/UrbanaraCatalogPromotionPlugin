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
}
