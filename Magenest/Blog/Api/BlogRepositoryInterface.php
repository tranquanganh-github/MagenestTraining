<?php

namespace Magenest\Blog\Api;

use Magenest\Blog\Api\Data\BlogInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;

interface BlogRepositoryInterface
{
    /**
     * Create blog
     *
     * @param BlogInterface $blog
     *
     * @return BlogInterface
     * @throws CouldNotSaveException
     * @throws LocalizedException
     */
    public function save(BlogInterface $blog);

    /**
     * Delete Blog
     *
     * @param BlogInterface $blog
     *
     * @return bool
     * @throws CouldNotSaveException
     * @throws LocalizedException
     */
    public function delete(BlogInterface $blog);

    /**
     * Get blog by blog_id
     *
     * @param int $blogId
     *
     * @return BlogInterface
     */
    public function getById(int $blogId);

    /**
     * Get blog by UrlRewrite
     *
     * @param string $urlRewrite
     *
     * @return BlogInterface
     */
    public function getByUrlRewrite(string $urlRewrite);
}
