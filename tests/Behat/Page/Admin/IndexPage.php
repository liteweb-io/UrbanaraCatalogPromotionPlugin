<?php

namespace Tests\Acme\SyliusCatalogPromotionBundle\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;

class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function isExclusive($promotionCode)
    {
        $tableAccessor = $this->getTableAccessor();
        $table = $this->getElement('table');
        $fields = $tableAccessor->getFieldFromRow($table, $tableAccessor->getRowWithFields($table, ['code' => $promotionCode]), 'exclusive');

        return 'Yes' === $fields->getText();
    }
}
