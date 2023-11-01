<?php

namespace Magenest\PromotionPopup\Helper;

use Magento\Config\Model\Config\Source\Enabledisable;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class GetConfigValue extends AbstractHelper
{
    public const XMP_PATH_MAGENEST_CONFIG = 'magenest_promotion_notification/general/';

    public const STATUS = 'status';

    public const NOTIFICATION = 'notification';

    public const CUSTOMER_GROUP = 'customer_group_list';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     *
     * @param Context              $context
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context              $context,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Retrieve config value by path
     *
     * @param string $path
     *
     * @return mixed
     */
    private function getConfigDataByPath(string $path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get config value for Status
     *
     * @return bool
     */
    public function getConfigValueStatus()
    {
        $status = $this->getConfigDataByPath(self::XMP_PATH_MAGENEST_CONFIG . self::STATUS);

        return (int)$status == Enabledisable::ENABLE_VALUE;
    }

    /**
     * Get config value for Notification
     *
     * @return string|null
     */
    public function getConfigValueNotification()
    {
        return $this->getConfigDataByPath(self::XMP_PATH_MAGENEST_CONFIG . self::NOTIFICATION);
    }

    /**
     * Get config value for Customer Group
     *
     * @return string[]
     */
    public function getConfigValueCustomerGroup()
    {
        $customerGroup = $this->getConfigDataByPath(self::XMP_PATH_MAGENEST_CONFIG . self::CUSTOMER_GROUP);

        return explode(",", $customerGroup) ?? [];
    }
}
