<?php

namespace Magenest\CustomerAvatar\Plugin\CustomerData;

use Magenest\CustomerAvatar\Helper\Customer\Attributes\Avatar as HelperAvatar;
use Magenest\CustomerAvatar\Setup\Patch\Data\CustomerAttributeAvatar;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Helper\View;
use Magento\Customer\Model\ResourceModel\AddressRepository;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Customer
{
    /**
     * @var CurrentCustomer
     */
    protected CurrentCustomer $currentCustomer;

    /**
     * @var View
     */
    protected View $customerViewHelper;

    /**
     * @var HelperAvatar
     */
    protected HelperAvatar $customerAvatar;

    /**
     * @var AddressRepository
     */
    protected AddressRepository $addressRepository;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param CurrentCustomer   $currentCustomer
     * @param View              $customerViewHelper
     * @param AddressRepository $addressRepository
     * @param HelperAvatar      $customerAvatar
     * @param LoggerInterface   $logger
     */
    public function __construct(
        CurrentCustomer   $currentCustomer,
        View              $customerViewHelper,
        AddressRepository $addressRepository,
        HelperAvatar      $customerAvatar,
        LoggerInterface   $logger
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->customerViewHelper = $customerViewHelper;
        $this->addressRepository = $addressRepository;
        $this->customerAvatar = $customerAvatar;
        $this->logger = $logger;
    }

    /**
     * After get section data for custome
     *
     * @param \Magento\Customer\CustomerData\Customer $subject
     *
     * @return array
     */
    public function afterGetSectionData(\Magento\Customer\CustomerData\Customer $subject)
    {
        if (!$this->currentCustomer->getCustomerId()) {
            return [];
        }
        $customer = $this->currentCustomer->getCustomer();
        $attriCode = CustomerAttributeAvatar::CUSTOMER_ATTRIBUTE_AVATAR;
        if ($customer->getCustomAttribute($attriCode) !== null) {
            $file = $customer->getCustomAttribute($attriCode)->getValue();
        } else {
            $file = '';
        }

        return [
            'fullname' => $this->customerViewHelper->getCustomerName($customer),
            'firstname' => $customer->getFirstname(),
            'websiteId' => $customer->getWebsiteId(),
            'email' => $customer->getEmail(),
            'phone' => $this->getPhoneNumber((int)$customer->getDefaultBilling()),
            'avatar' => $this->customerAvatar->getAvatarCurrentCustomer($file)
        ];
    }

    /**
     * Get current customer phone number
     *
     * @param int $billingAddressId
     *
     * @return string
     */
    public function getPhoneNumber(int $billingAddressId): string
    {
        try {
            if ($billingAddressId) {
                return $this->addressRepository->getById($billingAddressId)->getTelephone();
            }
        } catch (LocalizedException $e) {
            $this->logger->error(__($e->getMessage()));
        }

        return 'N/A';
    }
}
