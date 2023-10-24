<?php

namespace Magenest\Blog\Model;

use Magenest\Blog\Api\Data\BlogInterface;
use Magenest\Blog\Helper\UrlRewrite\Validate;
use Magenest\Blog\Model\ResourceModel\Blog as ResourceModel;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\UrlRewrite\Model\Exception\UrlAlreadyExistsException;

class Blog extends AbstractModel implements BlogInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_blog';

    /**
     * @var Validate
     */
    protected $helperValidate;

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
     * Constructor
     *
     * @param Context               $context
     * @param Registry              $registry
     * @param Validate              $helperValidate
     * @param AbstractResource|null $resource
     * @param AbstractDb|null       $resourceCollection
     * @param array                 $data
     */
    public function __construct(
        Context          $context,
        Registry         $registry,
        Validate         $helperValidate,
        AbstractResource $resource = null,
        AbstractDb       $resourceCollection = null,
        array            $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->helperValidate = $helperValidate;
    }

    /**
     * @inheritDoc
     */
    public function getAuthorId()
    {
        return $this->_getData(self::AUTHOR_ID);
    }

    /**
     * @inheritDoc
     */
    public function setAuthorId(int $authorId)
    {
        return $this->setData(self::AUTHOR_ID, $authorId);
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
    public function getDescription()
    {
        return $this->_getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getContent()
    {
        return $this->_getData(self::CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setContent(string $content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @inheritDoc
     */
    public function getUrlRewrite()
    {
        return $this->_getData(self::URL_REWRITE);
    }

    /**
     * @inheritDoc
     */
    public function setUrlRewrite(string $urlRewrite)
    {
        return $this->setData(self::URL_REWRITE, $urlRewrite);
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
    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getUpdateAt()
    {
        return $this->_getData(self::UPDATE_AT);
    }

    /**
     * @inheritDoc
     * @throws UrlAlreadyExistsException
     */
    public function beforeSave()
    {
        $origUrlRewrite = $this->getOrigData(self::URL_REWRITE);
        if (!$origUrlRewrite || $this->getUrlRewrite() !== $origUrlRewrite) {
            $this->helperValidate->validateBlogUrlRewrite($this);
        }

        return parent::beforeSave();
    }
}
