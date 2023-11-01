<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

class NewAction extends Action implements HttpGetActionInterface
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
