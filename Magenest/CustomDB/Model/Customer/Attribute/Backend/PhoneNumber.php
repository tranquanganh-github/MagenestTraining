<?php

namespace Magenest\CustomDB\Model\Customer\Attribute\Backend;

use Magenest\CustomDB\Helper\ChangeFormatPhoneNumber;
use Magenest\CustomDB\Setup\Patch\Data\CustomerPhoneNumber;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\DataObject;

class PhoneNumber extends AbstractBackend
{
    /**
     * @var ChangeFormatPhoneNumber
     */
    protected $helper;

    /**
     * Constructor
     *
     * @param ChangeFormatPhoneNumber $helper
     */
    public function __construct(
        ChangeFormatPhoneNumber $helper,
    ) {
        $this->helper = $helper;
    }

    /**
     * Prepare data
     *
     * @param DataObject $object
     *
     * @return PhoneNumber
     */
    public function beforeSave($object)
    {
        $attrCode = $this->getAttribute()->getAttributeCode();
        if ($attrCode === CustomerPhoneNumber::CUSTOMER_ATTRIBUTE_PHONE_NUMBER) {
            $phoneNumber = $object->getData($attrCode);
            if ($phoneNumber && is_string($phoneNumber)) {
                $value = $this->helper->changeInputPhoneNumber($phoneNumber);
                if ($value) {
                    $object->setData($attrCode, $value);
                }
            }
        }

        return parent::beforeSave($object);
    }
}
