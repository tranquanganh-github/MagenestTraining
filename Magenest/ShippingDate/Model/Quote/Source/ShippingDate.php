<?php

namespace Magenest\ShippingDate\Model\Quote\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ShippingDate implements OptionSourceInterface
{
    public const SHIPPING_ON_TODAY = 1;

    public const SHIPPING_ON_TODAY_LABEL = 'Same-day delivery';

    public const SHIPPING_ON_SELECTED_DATE = 2;

    public const SHIPPING_ON_SELECTED_DATE_LABEL = 'On-demand delivery';

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        $options = [];
        $availableOptions = $this->getOptionArray();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key
            ];
        }

        return $options;
    }

    /**
     * @inheritDoc
     */
    protected function getOptionArray(): array
    {
        return [
            self::SHIPPING_ON_TODAY => self::SHIPPING_ON_TODAY_LABEL,
            self::SHIPPING_ON_SELECTED_DATE => self::SHIPPING_ON_SELECTED_DATE_LABEL
        ];
    }

}
