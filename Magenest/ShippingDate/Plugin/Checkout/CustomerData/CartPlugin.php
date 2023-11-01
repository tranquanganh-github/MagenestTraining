<?php

namespace Magenest\ShippingDate\Plugin\Checkout\CustomerData;

use Magenest\ShippingDate\Api\Data\ShippingDateInterface;
use Magenest\ShippingDate\Model\ShippingDateRepository;
use Magento\Catalog\Model\ResourceModel\Url;
use Magento\Checkout\CustomerData\Cart;
use Magento\Checkout\CustomerData\ItemPoolInterface;
use Magento\Checkout\Helper\Data;
use Magento\Checkout\Model\Session;
use Magento\Framework\View\LayoutInterface;

class CartPlugin extends Cart
{
    /**
     * @var ShippingDateRepository
     */
    protected $shippingDateRepository;

    /**
     * Constructor
     *
     * @param Session                      $checkoutSession
     * @param Url                          $catalogUrl
     * @param \Magento\Checkout\Model\Cart $checkoutCart
     * @param Data                         $checkoutHelper
     * @param ItemPoolInterface            $itemPoolInterface
     * @param LayoutInterface              $layout
     * @param ShippingDateRepository       $shippingDateRepository
     * @param array                        $data
     */
    public function __construct(
        Session                      $checkoutSession,
        Url                          $catalogUrl,
        \Magento\Checkout\Model\Cart $checkoutCart,
        Data                         $checkoutHelper,
        ItemPoolInterface            $itemPoolInterface,
        LayoutInterface              $layout,
        ShippingDateRepository       $shippingDateRepository,
        array                        $data = []
    ) {
        parent::__construct(
            $checkoutSession,
            $catalogUrl,
            $checkoutCart,
            $checkoutHelper,
            $itemPoolInterface,
            $layout,
            $data
        );
        $this->shippingDateRepository = $shippingDateRepository;
    }

    /**
     * @inheritDoc
     */
    public function afterGetSectionData(Cart $subject, &$result)
    {
        $quote = $this->getQuote();
        if (!$quote || !$quote->getId()) {
            return $result;
        }

        $shippingDate = $this->shippingDateRepository->loadByQuoteId($quote->getId());
        if ($shippingDate) {
            $result[ShippingDateInterface::SHIPPING_DATE] = $shippingDate->getShippingDate();
        }

        return $result;
    }
}
