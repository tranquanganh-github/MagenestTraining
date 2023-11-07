<?php

namespace Magenest\BuyNow\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Helper extends AbstractHelper
{
    public const XML_PATH_BUY_NOW = 'magenest_buy_now/general/status_buy_now';

    public const XML_PATH_ADD_TO_CART = 'magenest_buy_now/general/status_add_to_cart';

    public const XML_PATH_PRODUCT_PRICE = 'magenest_buy_now/general/status_product_listing_price';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     *
     * @param Context $context
     */
    public function __construct(
        Context $context,
    ) {
        parent::__construct($context);
        $this->scopeConfig = $context->getScopeConfig();
    }

    /**
     * Get store config value
     *
     * @param string $path
     *
     * @return mixed
     */
    private function getConfigValue(string $path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get buy now config
     *
     * @return mixed
     */
    public function getBuyNowConfig()
    {
        return $this->getConfigValue(self::XML_PATH_BUY_NOW);
    }

    /**
     * Get add to cart config
     *
     * @return mixed
     */
    public function getAddToCartConfig()
    {
        return $this->getConfigValue(self::XML_PATH_ADD_TO_CART);
    }

    /**
     * Get product price config
     *
     * @return mixed
     */
    public function getProductPriceConfig()
    {
        return $this->getConfigValue(self::XML_PATH_PRODUCT_PRICE);
    }
}
