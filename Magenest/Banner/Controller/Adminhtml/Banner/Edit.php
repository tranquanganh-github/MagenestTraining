<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Magenest\Banner\Api\Data\BannerInterface;
use Magenest\Banner\Model\Banner;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;
use Psr\Log\LoggerInterface;

class Edit extends Action implements HttpGetActionInterface
{
    public const MAIN_MENU_ACTIVE = 'Magenest_Banner::general';

    public const REDIRECT_PATH = 'magenest/banner/index';

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var BannerInterface
     */
    protected $bannerModel;

    /**
     * Constructor
     *
     * @param Context         $context
     * @param LoggerInterface $logger
     * @param BannerInterface $bannerModel
     */
    public function __construct(
        Context         $context,
        LoggerInterface $logger,
        BannerInterface $bannerModel
    ) {
        parent::__construct($context);
        $this->logger = $logger;
        $this->bannerModel = $bannerModel;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /** @var $model Banner */
        $model = $this->bannerModel;
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists.'));

                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath(self::REDIRECT_PATH);
            }
        }

        /** @var $resultRedirect Page */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu(self::MAIN_MENU_ACTIVE);
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId() ? __($model->getName()) : __('Add New Banner')
        );

        return $resultPage;
    }
}
