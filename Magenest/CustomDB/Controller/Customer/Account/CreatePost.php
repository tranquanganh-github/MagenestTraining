<?php

namespace Magenest\CustomDB\Controller\Customer\Account;

use Magenest\CustomDB\Helper\ChangeFormatPhoneNumber;
use Magenest\CustomDB\Setup\Patch\Data\CustomerPhoneNumber;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Api\Data\RegionInterfaceFactory;
use Magento\Customer\Controller\Account\CreatePost as MagentoCreatePost;
use Magento\Customer\Helper\Address;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Model\CustomerExtractor;
use Magento\Customer\Model\Metadata\FormFactory;
use Magento\Customer\Model\Registration;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Escaper;
use Magento\Framework\UrlFactory;
use Magento\Newsletter\Model\SubscriberFactory;
use Magento\Store\Model\StoreManagerInterface;

class CreatePost extends MagentoCreatePost
{

    /**
     * @var ChangeFormatPhoneNumber
     */
    protected $helperPhoneNumber;

    /**
     * Constructor
     *
     * @param Context                    $context
     * @param Session                    $customerSession
     * @param ScopeConfigInterface       $scopeConfig
     * @param StoreManagerInterface      $storeManager
     * @param AccountManagementInterface $accountManagement
     * @param Address                    $addressHelper
     * @param UrlFactory                 $urlFactory
     * @param FormFactory                $formFactory
     * @param SubscriberFactory          $subscriberFactory
     * @param RegionInterfaceFactory     $regionDataFactory
     * @param AddressInterfaceFactory    $addressDataFactory
     * @param CustomerInterfaceFactory   $customerDataFactory
     * @param CustomerUrl                $customerUrl
     * @param Registration               $registration
     * @param Escaper                    $escaper
     * @param CustomerExtractor          $customerExtractor
     * @param DataObjectHelper           $dataObjectHelper
     * @param AccountRedirect            $accountRedirect
     * @param CustomerRepository         $customerRepository
     * @param ChangeFormatPhoneNumber    $helperPhoneNumber
     * @param Validator|null             $formKeyValidator
     */
    public function __construct(
        Context                    $context,
        Session                    $customerSession,
        ScopeConfigInterface       $scopeConfig,
        StoreManagerInterface      $storeManager,
        AccountManagementInterface $accountManagement,
        Address                    $addressHelper,
        UrlFactory                 $urlFactory,
        FormFactory                $formFactory,
        SubscriberFactory          $subscriberFactory,
        RegionInterfaceFactory     $regionDataFactory,
        AddressInterfaceFactory    $addressDataFactory,
        CustomerInterfaceFactory   $customerDataFactory,
        CustomerUrl                $customerUrl,
        Registration               $registration,
        Escaper                    $escaper,
        CustomerExtractor          $customerExtractor,
        DataObjectHelper           $dataObjectHelper,
        AccountRedirect            $accountRedirect,
        CustomerRepository         $customerRepository,
        ChangeFormatPhoneNumber    $helperPhoneNumber,
        Validator                  $formKeyValidator = null
    ) {
        parent::__construct(
            $context,
            $customerSession,
            $scopeConfig,
            $storeManager,
            $accountManagement,
            $addressHelper,
            $urlFactory,
            $formFactory,
            $subscriberFactory,
            $regionDataFactory,
            $addressDataFactory,
            $customerDataFactory,
            $customerUrl,
            $registration,
            $escaper,
            $customerExtractor,
            $dataObjectHelper,
            $accountRedirect,
            $customerRepository,
            $formKeyValidator
        );
        $this->helperPhoneNumber = $helperPhoneNumber;
    }

    /**
     * Before execute
     *
     * @param MagentoCreatePost $object
     *
     * @return MagentoCreatePost
     */
    public function beforeExecute(MagentoCreatePost $object)
    {
        $param = $this->getRequest()->getPostValue();
        if (!empty($param)) {
            foreach ($param as $k => &$v) {
                if ($k === CustomerPhoneNumber::CUSTOMER_ATTRIBUTE_PHONE_NUMBER) {
                    $v = $this->helperPhoneNumber->changeInputPhoneNumber($v);
                }
            }
            unset($v);
        }
        $this->getRequest()->setPostValue($param);

        return $object;
    }
}
