<?php

namespace Magenest\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BlogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return BlogInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param BlogInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
