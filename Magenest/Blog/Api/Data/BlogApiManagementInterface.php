<?php

namespace Magenest\Blog\Api\Data;

interface BlogApiManagementInterface
{
    /**
     * Save api blog data using Repo
     *
     * @api
     * @param BlogInterface $blog
     *
     * @return BlogInterface
     */
    public function saveBlog(BlogInterface $blog);

    /**
     * Delete api blog data using Repo
     *
     * @api
     * @param BlogInterface $blog
     *
     * @return bool Will returned True if deleted
     */
    public function deleteBlog(BlogInterface $blog);
}
