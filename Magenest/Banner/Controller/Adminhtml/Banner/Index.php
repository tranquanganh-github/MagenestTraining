<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * Constructor
     *
     * @param Context     $context
     * @param PageFactory $rawFactory
     */
    public function __construct(
        Context     $context,
        PageFactory $rawFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $rawFactory;
    }

    /**
     * Add the main Admin Grid page
     *
     * @return Page
     */
    public function execute(): Page
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Magenest Banner List'));

        return $resultPage;
    }
}
