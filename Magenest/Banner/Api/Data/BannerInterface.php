<?php

namespace Magenest\Banner\Api\Data;

interface BannerInterface
{
    public const ID = 'entity_id';

    public const LAYOUT_UPDATE_ID = 'layout_update_id';

    public const NAME = 'name';

    public const STATUS = 'is_active';

    public const TITLE = 'title';

    public const IMAGE = 'image';

    public const URL_PAGE = 'url_page';

    public const TEXT = 'text';

    /**
     * Get banner name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set banner name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name);

    /**
     * Get layout update id
     *
     * @return int|null
     */
    public function getLayoutUpdateId();

    /**
     * Set layout update id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setLayoutUpdateId(int $id);

    /**
     * Get banner status
     *
     * @return bool
     */
    public function getStatus();

    /**
     * Set banner status
     *
     * @param bool $status
     *
     * @return $this
     */
    public function setStatus(bool $status);

    /**
     * Get banner title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Set banner title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * Get banner Image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Set banner Image
     *
     * @param string $img
     *
     * @return $this
     */
    public function setImage(string $img);

    /**
     * Get url page
     *
     * @return string|null
     */
    public function getUrlPage();

    /**
     * Set url page
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrlPage(string $url);

    /**
     * Get text
     *
     * @return string|null
     */
    public function getText();

    /**
     * Set text
     *
     * @param string $text
     *
     * @return $this
     */
    public function setText(string $text);
}
