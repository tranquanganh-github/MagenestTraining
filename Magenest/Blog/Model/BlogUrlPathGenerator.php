<?php

namespace Magenest\Blog\Model;

class BlogUrlPathGenerator
{
    public const XML_PATH_BLOG_VIEW = 'magenest/blog/view/id/';

    /**
     * @param Blog $blog
     *
     * @return string|null
     */
    public function getPathUrl(Blog $blog)
    {
        return $blog->getid() ? self::XML_PATH_BLOG_VIEW . $blog->getId() : null;
    }
}
