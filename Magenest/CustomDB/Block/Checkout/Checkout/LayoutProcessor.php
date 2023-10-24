<?php

namespace Magenest\CustomDB\Block\Checkout\Checkout;

use Magenest\CustomDB\Model\Customer\Address\Attribute\Source\Region;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class LayoutProcessor implements LayoutProcessorInterface
{
    /**
     * @var Region
     */
    protected $region;

    /**
     * @param Region $region
     */
    public function __construct(Region $region)
    {
        $this->region = $region;
    }

    /**
     * Process js Layout of block
     *
     * @param array $jsLayout
     *
     * @return array
     */
    public function process($jsLayout)
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['vn_region'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress.vn_region',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.vn_region',
            'label' => __('Viet Nam Region'),
            'provider' => 'checkoutProvider',
            'validation' => ['required-entry' => true],
            'options' => $this->region->toOptionArray(),
            'visible' => true,
            'sortOrder' => '45'
        ];

        return $jsLayout;
    }
}
