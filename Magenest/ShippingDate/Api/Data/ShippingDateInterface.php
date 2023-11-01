<?php

namespace Magenest\ShippingDate\Api\Data;

interface ShippingDateInterface
{
    public const QUOTE_ID = 'quote_id';

    public const STATUS = 'status';

    public const SHIPPING_DATE = 'shipping_date';

    /**
     * Get quote id
     *
     * @return int|null
     */
    public function getQuoteId();

    /**
     * Set quote id
     *
     * @param int $quoteId
     *
     * @return $this
     */
    public function setQuoteId(int $quoteId);

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param bool $status
     *
     * @return $this
     */
    public function setStatus(bool $status);

    /**
     * Get shipping date
     *
     * @return string|null
     */
    public function getShippingDate();

    /**
     * Set shipping date
     *
     * @param string $shippingDate
     *
     * @return $this
     */
    public function setShippingDate(string $shippingDate);
}
