<?php

namespace Magenest\ShippingDate\Api;

use Magenest\ShippingDate\Model\ShippingDate;

interface ShippingDateRepositoryInterface
{
    /**
     * Load shipping date by quote id
     *
     * @param int $quoteId
     *
     * @return ShippingDate|null
     */
    public function loadByQuoteId(int $quoteId);
}
