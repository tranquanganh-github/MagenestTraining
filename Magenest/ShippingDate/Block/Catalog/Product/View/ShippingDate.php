<?php

namespace Magenest\ShippingDate\Block\Catalog\Product\View;

use Magenest\ShippingDate\Model\Quote\Source\ShippingDate as SourceOption;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class ShippingDate extends Template
{
    /**
     * @var SourceOption
     */
    protected $shippingDate;

    /**
     * Constructor
     *
     * @param Context      $context
     * @param SourceOption $shippingDate
     * @param array        $data
     */
    public function __construct(
        Template\Context $context,
        SourceOption     $shippingDate,
        array            $data = []
    ) {
        parent::__construct($context, $data);
        $this->shippingDate = $shippingDate;
    }

    /**
     * Get option for shipping date
     *
     * @return array
     */
    public function getShippingDateOptions()
    {
        return $this->shippingDate->toOptionArray();
    }
}
