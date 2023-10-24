<?php

namespace Magenest\Blog\Model\ResourceModel\Category;

use \Magenest\Blog\Model\Category as Model;
use \Magenest\Blog\Model\ResourceModel\Category as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(Model::class, ResourceModel::class);
    }
}
