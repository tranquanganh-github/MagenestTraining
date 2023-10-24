<?php

namespace Magenest\Blog\Model\ResourceModel\Blog;

use \Magenest\Blog\Model\Blog as Model;
use \Magenest\Blog\Model\ResourceModel\Blog as ResourceModel;
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
