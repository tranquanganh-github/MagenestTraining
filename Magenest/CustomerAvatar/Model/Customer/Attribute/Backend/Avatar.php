<?php

namespace Magenest\CustomerAvatar\Model\Customer\Attribute\Backend;

use Magenest\CustomerAvatar\Model\Customer\Source\Validation\Image as ImageValidation;
use Magenest\CustomerAvatar\Setup\Patch\Data\CustomerAttributeAvatar;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class Avatar extends AbstractBackend
{
    /**
     * @var ImageValidation
     */
    protected ImageValidation $imageValidation;

    /**
     * Constructor
     *
     * @param ImageValidation $imageValidation
     */
    public function __construct(
        ImageValidation $imageValidation,
    ) {
        $this->imageValidation = $imageValidation;
    }

    /**
     * Before save method
     *
     * @param DataObject $object
     *
     * @return $this
     * @throws LocalizedException
     */
    public function beforeSave($object)
    {
        $attrCode = $this->getAttribute()->getAttributeCode();
        if ($this->isValid($attrCode) === false) {
            throw new LocalizedException(
                __('The profile picture is not a valid image.')
            );
        }

        return parent::beforeSave($object);
    }

    /**
     * Is Validation Attribute customer avatar
     *
     * @param string $attrCode
     *
     * @return bool
     */
    private function isValid(string $attrCode): bool
    {
        return ($attrCode === CustomerAttributeAvatar::CUSTOMER_ATTRIBUTE_AVATAR)
            && $this->imageValidation->isValid('tmp_name', $attrCode);
    }
}
