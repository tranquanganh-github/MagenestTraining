<?php

namespace Magenest\ShippingDate\Model\ResourceModel\ShippingDate;

use Magenest\ShippingDate\Model\ResourceModel\ShippingDate as ResourceModel;
use Magenest\ShippingDate\Model\ShippingDate as Model;
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
