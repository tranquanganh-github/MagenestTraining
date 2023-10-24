<?php

namespace Magenest\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Category extends AbstractDb
{
    public const MAIN_TABLE = 'magenest_category';

    /**
     * @inheirtDoc
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, 'entity_id');
    }
}
