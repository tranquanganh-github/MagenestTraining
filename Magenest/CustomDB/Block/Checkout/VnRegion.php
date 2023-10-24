<?php

namespace Magenest\CustomDB\Block\Checkout;

use Magenest\CustomDB\Model\Customer\Address\Attribute\Source\Region;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class VnRegion extends Template
{
    /**
     * @var Region
     */
    protected Region $region;

    /**
     * @param Context $context
     * @param Region  $region
     * @param array   $data
     */
    public function __construct(
        Template\Context $context,
        Region           $region,
        array            $data = []
    ) {
        parent::__construct($context, $data);
        $this->region = $region;
    }

    /**
     * Get vn region array
     *
     * @throws \JsonException
     */
    public function getSerializedConfig()
    {
        $data = $this->region->toOptionArray();

        return json_encode($data, JSON_THROW_ON_ERROR);
    }
}
