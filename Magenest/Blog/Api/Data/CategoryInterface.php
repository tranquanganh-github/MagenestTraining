<?php

namespace Magenest\Blog\Api\Data;

interface CategoryInterface
{
    public const NAME = 'name';

    /**
     * Get category name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set category name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name);
}
