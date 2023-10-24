<?php

namespace Magenest\CustomDB\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class ChangeFormatPhoneNumber extends AbstractHelper
{
    public const PHONE_NUMBER_FORMAT_1 = '/^\+?([0-9]{2})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{3})?[-. ]?([0-9]{3})$/';
    public const PHONE_NUMBER_FORMAT_2 = '/^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/';
    public const PHONE_NUMBER_FORMAT_3 = '/^\+?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/';

    /**
     * Change phone number from international format to country format
     *
     * @param string $phoneNumber
     *
     * @return string|null
     */
    public function changeInputPhoneNumber(string $phoneNumber)
    {
        if ($phoneNumber) {
            $value = $this->isValidPhoneNumber($phoneNumber);
            if ($value !== null) {
                $result = '0';
                for ($x = 2, $xMax = count($value); $x < $xMax; $x++) {
                    $result .= $value[$x];
                }

                return $result;
            }
        }

        return null;
    }

    /**
     * Is valid phone number
     *
     * @param string $phoneNumber
     *
     * @return string[]|null
     */
    public function isValidPhoneNumber(string $phoneNumber)
    {
        if (preg_match(
            self::PHONE_NUMBER_FORMAT_1,
            $phoneNumber,
            $value
        )) {
            return $value;
        }

        if (preg_match(
            self::PHONE_NUMBER_FORMAT_2,
            $phoneNumber,
            $value
        )) {
            return $value;
        }
        if (preg_match(
            self::PHONE_NUMBER_FORMAT_3,
            $phoneNumber,
            $value
        )) {
            return $value;
        }

        return null;
    }
}
