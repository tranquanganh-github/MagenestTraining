<?php

namespace Magenest\CustomerAvatar\Model\Customer\Source\Validation;

use Magenest\CustomerAvatar\Setup\Patch\Data\CustomerAttributeAvatar;

class Image
{
    /**
     * Is Valid
     *
     * @param string $tmpName
     * @param string $attrCode
     *
     * @return bool
     */
    public function isValid(string $tmpName, string $attrCode): bool
    {
        return $this->isValidImage($tmpName, $attrCode);
    }

    /**
     * Validation Image
     *
     * @param string $tmpName
     * @param string $attrCode
     *
     * @return bool
     */
    private function isValidImage(string $tmpName, string $attrCode): bool
    {
        $file = $_FILES;
        $customerAttribute = CustomerAttributeAvatar::CUSTOMER_ATTRIBUTE_AVATAR;
        if (($attrCode === $customerAttribute) && !empty($file[$attrCode][$tmpName])) {
            $imageFile = @getimagesize($file[$attrCode][$tmpName]);
            $validTypes = ['image/gif', 'image/jpeg', 'image/png'];
            if ($imageFile === false || !in_array($imageFile['mime'], $validTypes, true)) {
                return false;
            }
        }

        return true;
    }
}
