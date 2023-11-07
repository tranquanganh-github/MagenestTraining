<?php

namespace Magenest\BuyNow\ViewModel\Catalog\Product;

use Magenest\BuyNow\Helper\Helper;
use Magento\Config\Model\Config\Source\Enabledisable;
use Magento\Customer\Model\Session;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ListProduct implements ArgumentInterface
{
    public const PATH_TO_CART_PAGE = 'checkout/cart/index';

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Session
     */
    protected $session;

    /**
     * Constructor
     *
     * @param Helper       $helper
     * @param UrlInterface $urlBuilder
     * @param Session      $session
     */
    public function __construct(
        Helper       $helper,
        UrlInterface $urlBuilder,
        Session      $session
    ) {
        $this->helper = $helper;
        $this->urlBuilder = $urlBuilder;
        $this->session = $session;
    }

    /**
     * Is valid for display buy now button
     *
     * @return bool
     */
    public function isValidBuyNowConfig()
    {
        return (int)$this->helper->getBuyNowConfig() === Enabledisable::ENABLE_VALUE;
    }

    /**
     * Is valid for display add to cart button
     *
     * @return bool
     */
    public function isValidAddToCartConfig()
    {
        if (((int)$this->helper->getAddToCartConfig() === Enabledisable::ENABLE_VALUE)
            && !$this->session->isLoggedIn()
        ) {
            return false;
        }

        return true;
    }

    /**
     * Is valid for display product price
     *
     * @return bool
     */
    public function isValidProductPriceConfig()
    {
        return (int)$this->helper->getProductPriceConfig() === Enabledisable::ENABLE_VALUE;
    }

    /**
     * Get cart page url
     *
     * @return string
     */
    public function getCartPageUrl()
    {
        $url = $this->urlBuilder->getUrl(self::PATH_TO_CART_PAGE);

        return json_encode(
            [
                'cartPage' => $url
            ]
        );
    }

    /**
     * Get Validation Rules for Quantity field
     *
     * @return array
     */
    public function getQuantityValidators()
    {
        $validators = [];
        $validators['required-number'] = true;
        $validators['validate-greater-than-zero'] = true;

        return $validators;
    }
}
