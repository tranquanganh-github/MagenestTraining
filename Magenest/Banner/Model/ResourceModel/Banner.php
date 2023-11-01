<?php

namespace Magenest\Banner\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb
{
    public const MAIN_TABLE = 'magenest_banner';

    public const FIELD_ID = 'entity_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::FIELD_ID);
    }
}
