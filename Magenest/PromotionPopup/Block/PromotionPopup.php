<?php

namespace Magenest\PromotionPopup\Block;

use Magenest\PromotionPopup\Helper\GetConfigValue;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class PromotionPopup extends Template
{
    /**
     * @var GetConfigValue
     */
    protected $helper;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * Constructor
     *
     * @param Context        $context
     * @param GetConfigValue $helper
     * @param Session        $customerSession
     * @param array          $data
     */
    public function __construct(
        Template\Context $context,
        GetConfigValue   $helper,
        Session          $customerSession,
        array            $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
        $this->customerSession = $customerSession;
    }

    /**
     * Get config value
     *
     * @return array
     */
    public function getConfigValue()
    {
        return [
            'status' => $this->helper->getConfigValueStatus(),
            'notification' => $this->helper->getConfigValueNotification(),
            'customer_group' => $this->helper->getConfigValueCustomerGroup()
        ];
    }

    /**
     * Check status for display popup
     *
     * @param mixed $customerGroupIds
     * @param bool  $status
     *
     * @return bool
     */
    public function isValidToDisplay(array $customerGroupIds, bool $status)
    {
        if (!$status || empty($customerGroupIds)) {
            return false;
        }

        $customer = $this->customerSession->getCustomer();
        if (!$customer) {
            return false;
        }

        return !in_array((string)$customer->getGroupId(), $customerGroupIds, true);
    }
}
