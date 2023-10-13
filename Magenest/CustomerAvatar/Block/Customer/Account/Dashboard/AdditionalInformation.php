<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\CustomerAvatar\Block\Customer\Account\Dashboard;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class AdditionalInformation extends Template
{
    /**
     * @var CurrentCustomer
     */
    protected CurrentCustomer $currentCustomer;

    /**
     * @param Context         $context
     * @param CurrentCustomer $currentCustomer
     * @param array           $data
     */
    public function __construct(
        Template\Context $context,
        CurrentCustomer  $currentCustomer,
        array            $data = []
    ) {
        parent::__construct($context, $data);
        $this->currentCustomer = $currentCustomer;
    }

    /**
     * Returns the Magento Customer Model for this block
     *
     * @return CustomerInterface|null
     */
    public function getCustomer()
    {
        return $this->currentCustomer->getCustomer();
    }
}
