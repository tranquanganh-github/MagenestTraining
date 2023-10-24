<?php

namespace Magenest\Blog\Controller\Blog;

use Magenest\Blog\Model\BlogRepository;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class View extends Action
{
    /**
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context        $context
     * @param BlogRepository $blogRepository
     * @param PageFactory    $resultPageFactory
     */
    public function __construct(
        Context        $context,
        BlogRepository $blogRepository,
        PageFactory    $resultPageFactory,
    ) {
        parent::__construct($context);
        $this->blogRepository = $blogRepository;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $blogId = $this->getRequest()->getParam('id');
        if ($blogId) {
            $blog = $this->blogRepository->getById($blogId);
            if (!$blog) {
                $resultRedirect = $this->resultRedirectFactory->create();
                $this->messageManager->addErrorMessage(__('Something Wrong please try again.'));
                $resultRedirect->setUrl($this->_url->getBaseUrl());

                return $resultRedirect;
            }
        }

        return $this->resultPageFactory->create();
    }
}
