<?php

namespace Magenest\Blog\Model;

use Magenest\Blog\Api\Data\CategoryInterface;
use Magento\Framework\Model\AbstractModel;
use \Magenest\Blog\Model\ResourceModel\Category as ResourceModel;

class Category extends AbstractModel implements CategoryInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel::class);
        $this->setIdFieldName('entity_id');
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }
}
