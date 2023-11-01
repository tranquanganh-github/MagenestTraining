<?php

namespace Magenest\ShippingDate\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ShippingDate extends AbstractDb
{
    public const MAIN_TABLE = 'magenest_shipping_date';
    public const FIELD_ID = 'entity_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::FIELD_ID);
    }
}
