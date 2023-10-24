<?php

namespace Magenest\Blog\Model;

use Exception;
use Magenest\Blog\Api\BlogRepositoryInterface;
use Magenest\Blog\Api\Data\BlogInterface;
use Magenest\Blog\Model\Blog as BlogModel;
use Magenest\Blog\Model\BlogFactory as BlogModelFactory;
use Magenest\Blog\Model\ResourceModel\Blog as BlogResourceModel;
use Magenest\Blog\Model\ResourceModel\Blog\Collection as BlogCollection;
use Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magenest\Blog\Model\ResourceModel\BlogFactory as BlogResourceModelFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class BlogRepository implements BlogRepositoryInterface
{
    /**
     * @var BlogFactory
     */
    protected $modelFactory;

    /**
     * @var BlogResourceModelFactory
     */
    protected $resourceModelFactory;

    /**
     * @var BlogCollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param BlogFactory              $modelFactory
     * @param BlogResourceModelFactory $resourceModelFactory
     * @param BlogCollectionFactory    $collectionFactory
     */
    public function __construct(
        BlogModelFactory         $modelFactory,
        BlogResourceModelFactory $resourceModelFactory,
        BlogCollectionFactory    $collectionFactory,
    ) {
        $this->modelFactory = $modelFactory;
        $this->resourceModelFactory = $resourceModelFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Create / Edit blog
     *
     * @param BlogInterface $blog
     *
     * @return BlogInterface
     * @throws AlreadyExistsException
     * @throws CouldNotSaveException
     * @throws LocalizedException
     */
    public function save(BlogInterface $blog)
    {
        try {
            $blogId = $blog->getId();
            if ($blogId) {
                $blog = $this->getById($blogId);
            }
            /** @var $resourceModel BlogResourceModel */
            $resourceModel = $this->resourceModelFactory->create();
            $resourceModel->save($blog);
        } catch (LocalizedException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new CouldNotSaveException(
                __('Blog was unable to be saved. Please try again.'),
                $e
            );
        }

        return $blog;
    }

    /**
     * Delete Blog
     *
     * @param BlogInterface $blog
     *
     * @return true
     * @throws CouldNotSaveException
     * @throws LocalizedException
     */
    public function delete(BlogInterface $blog)
    {
        try {
            $blogId = $blog->getId();
            if ($blogId) {
                /** @var $model BlogModel */
                $model = $this->modelFactory->create();
                $model->load($blogId);
                /** @var $resourceModel BlogResourceModel */
                $resourceModel = $this->resourceModelFactory->create();
                $resourceModel->delete($model);
            }
        } catch (LocalizedException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new CouldNotSaveException(
                __('Blog was unable to be delete. Please try again.'),
                $e
            );
        }

        return true;
    }

    /**
     * Get blog by blog id
     *
     * @param int $blogId
     *
     * @return Blog|null
     * @throws NoSuchEntityException
     */
    public function getById(int $blogId)
    {
        if (!$blogId) {
            return null;
        }
        /** @var $model BlogModel */
        $model = $this->modelFactory->create();
        $model->load($blogId);
        if (!$model->getId()) {
            throw new NoSuchEntityException(
                __("The Blog that was requested doesn't exist. Verify blog and try again.")
            );
        }

        return $model;
    }

    /**
     * Get blog by url rewrite
     *
     * @param string $urlRewrite
     *
     * @return array|null
     * @throws NoSuchEntityException
     */
    public function getByUrlRewrite(string $urlRewrite)
    {
        if (!$urlRewrite) {
            return null;
        }

        /** @var $collection BlogCollection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(BlogInterface::URL_REWRITE, ['eq' => $urlRewrite]);
        $blogs = $collection->getData();
        if (empty($blogs)) {
            return null;
        }

        $collectionResult = [];
        /** @var $model BlogModel */
        $model = $this->modelFactory->create();
        foreach ($blogs as $item) {
            $model->load(($item->getId()));
            if (!$model->getId()) {
                throw new NoSuchEntityException(
                    __("The Blog that was requested doesn't exist. Verify blog and try again.")
                );
            }
            $collectionResult[] = $model;
        }

        return $collectionResult;
    }
}
