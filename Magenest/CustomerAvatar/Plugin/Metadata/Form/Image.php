<?php

namespace Magenest\CustomerAvatar\Plugin\Metadata\Form;

use Magenest\CustomerAvatar\Model\Customer\Source\Validation\Image as ImageValidation;
use Magento\Customer\Model\Metadata\Form\Image as MagentoImage;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Image
{
    /**
     * @var ImageValidation
     */
    protected ImageValidation $imageValidation;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param ImageValidation $imageValidation
     * @param LoggerInterface $logger
     */
    public function __construct(
        ImageValidation $imageValidation,
        LoggerInterface $logger
    ) {
        $this->imageValidation = $imageValidation;
        $this->logger = $logger;
    }

    /**
     * Before extractValue
     *
     * @param MagentoImage $subject
     * @param              $result
     *
     * @return array
     */
    public function beforeExtractValue(MagentoImage $subject, $result)
    {
        try {
            $attrCode = $subject->getAttribute()->getAttributeCode();
            if ($attrCode && $this->imageValidation->isValid('tmp_name', $attrCode) === false) {
                $_FILES[$attrCode]['tmp_name'] = $_FILES[$attrCode]['tmp_name'];
                unset($_FILES[$attrCode]['tmp_name']);
            }

        } catch (LocalizedException $e) {
            $this->logger->critical($e);
        }

        return [$result];
    }
}
