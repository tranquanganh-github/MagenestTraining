<?php

namespace Magenest\Blog\Model\Api;

use Magenest\Blog\Api\BlogRepositoryInterface;
use Magenest\Blog\Api\Data\BlogApiManagementInterface;
use Magenest\Blog\Api\Data\BlogInterface;
use Magenest\Blog\Model\BlogRepository;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;

class BlogApiManagement implements BlogApiManagementInterface
{
    /**
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * Constructor
     *
     * @param BlogRepository $blogRepository
     */
    public function __construct(
        BlogRepository $blogRepository
    ) {
        $this->blogRepository = $blogRepository;
    }

    /**
     * @inheritDoc
     */
    public function saveBlog(BlogInterface $blog)
    {
        try {
            return $this->blogRepository->save($blog);
        } catch (CouldNotSaveException $e) {
            throw new CouldNotSaveException(
                __($e->getMessage()),
                $e
            );
        } catch (LocalizedException $e) {
            throw new LocalizedException(
                __('Blog was unable to be saved LE. Please try again.'),
                $e
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteBlog(BlogInterface $blog)
    {
        try {
            $this->blogRepository->delete($blog);
        } catch (CouldNotSaveException $e) {
            throw new CouldNotSaveException(
                __('Blog was unable to be delete. Please try again.'),
                $e
            );
        } catch (LocalizedException $e) {
            throw new LocalizedException(
                __('Blog was unable to be delete. Please try again.'),
                $e
            );
        }
    }
}
