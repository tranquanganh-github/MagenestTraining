<?php

namespace Magenest\Banner\Model;

use Magenest\Banner\Api\Data\BannerInterface;
use Magenest\Banner\Model\ResourceModel\Banner as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Banner extends AbstractModel implements BannerInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_banner';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
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

    /**
     * @inheritDoc
     */
    public function getLayoutUpdateId()
    {
        return $this->_getData(self::LAYOUT_UPDATE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLayoutUpdateId(int $id)
    {
        return $this->setData(self::LAYOUT_UPDATE_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(bool $status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->_getData(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getImage()
    {
        return $this->_getData(self::IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setImage(string $img)
    {
        return $this->setData(self::IMAGE, $img);
    }

    /**
     * @inheritDoc
     */
    public function getUrlPage()
    {
        return $this->_getData(self::URL_PAGE);
    }

    /**
     * @inheritDoc
     */
    public function setUrlPage(string $url)
    {
        return $this->setData(self::URL_PAGE, $url);
    }

    /**
     * @inheritDoc
     */
    public function getText()
    {
        return $this->_getData(self::TEXT);
    }

    /**
     * @inheritDoc
     */
    public function setText(string $text)
    {
        return $this->setData(self::TEXT, $text);
    }
}
