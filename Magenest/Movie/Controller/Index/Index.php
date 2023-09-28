<?php

namespace Magenest\Movie\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $result = $this->resultPageFactory->create();

        return $result;
    }
}
