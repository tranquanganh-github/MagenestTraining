<?php

namespace Magenest\Blog\Api\Data;

interface BlogInterface
{
    public const AUTHOR_ID = 'author_id';

    public const TITLE = 'title';

    public const DESCRIPTION = 'description';

    public const CONTENT = 'content';

    public const URL_REWRITE = 'url_rewrite';

    public const STATUS = 'status';

    public const CREATED_AT = 'created_at';

    public const UPDATE_AT = 'update_at';

    /**
     * Get author id (admin user id)
     *
     * @return int|null
     */
    public function getAuthorId();

    /**
     * Set author id (admin user id)
     *
     * @param int $authorId
     *
     * @return $this
     */
    public function setAuthorId(int $authorId);

    /**
     * Get blog title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Set blog title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * Get blog description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Set blog description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description);

    /**
     * Get blog content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Set blog content
     *
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content);

    /**
     * Get blog url_rewrite
     *
     * @return string|null
     */
    public function getUrlRewrite();

    /**
     * Set blog url_rewrite
     *
     * @param string $urlRewrite
     *
     * @return $this
     */
    public function setUrlRewrite(string $urlRewrite);

    /**
     * Get blog status
     *
     * @return boolean|null
     */
    public function getStatus();

    /**
     * Set blog status
     *
     * @param bool $status
     *
     * @return $this
     */
    public function setStatus(bool $status);

    /**
     * Get blog created at
     *
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * Get blog update at
     *
     * @return mixed
     */
    public function getUpdateAt();
}
