<?php

namespace Magenest\ShippingDate\Model;

use Magenest\ShippingDate\Api\Data\ShippingDateInterface;
use Magenest\ShippingDate\Model\ResourceModel\ShippingDate as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class ShippingDate extends AbstractModel implements ShippingDateInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getQuoteId()
    {
        return $this->_getData(self::QUOTE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setQuoteId(int $quoteId)
    {
        return $this->setData(self::QUOTE_ID, $quoteId);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(bool $status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getShippingDate()
    {
        return $this->_getData(self::SHIPPING_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setShippingDate(string $shippingDate)
    {
        return $this->setData(self::SHIPPING_DATE, $shippingDate);
    }
}
