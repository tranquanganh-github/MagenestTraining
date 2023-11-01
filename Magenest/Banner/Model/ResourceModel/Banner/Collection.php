<?php

namespace Magenest\Banner\Model\ResourceModel\Banner;

use Magenest\Banner\Model\Banner as Model;
use Magenest\Banner\Model\ResourceModel\Banner as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
