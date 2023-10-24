<?php

namespace Magenest\CustomDB\Model\Customer\Address\Attribute\Source;

use Magento\Customer\Model\Customer\Source\GroupSourceInterface;

class Region implements GroupSourceInterface
{
    public const THE_NORTHERN_VIET_NAM = 'Miền Bắc';
    public const THE_CENTER_VIET_NAM = 'Miền Trung';
    public const THE_SOUTHERN_VIET_NAM = 'Miền Nam';

    /**
     * To options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = $this->getOptionArray();
        $regions = [];
        foreach ($options as $k => $v) {
            $regions[] = [
                'label' => $v,
                'value' => $k,
            ];
        }

        return $regions;
    }

    /**
     * Get option array
     *
     * @return string[]
     */
    public function getOptionArray()
    {
        return [
            1 => self::THE_NORTHERN_VIET_NAM,
            2 => self::THE_CENTER_VIET_NAM,
            3 => self::THE_SOUTHERN_VIET_NAM
        ];
    }
}
