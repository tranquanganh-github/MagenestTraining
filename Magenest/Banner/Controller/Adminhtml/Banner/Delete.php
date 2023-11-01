<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Magenest\Banner\Api\Data\BannerInterface;
use Magenest\Banner\Model\Banner;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @var BannerInterface
     */
    protected $bannerModel;

    /**
     * Constructor
     *
     * @param Context         $context
     * @param BannerInterface $bannerModel
     */
    public function __construct(
        Context         $context,
        BannerInterface $bannerModel,
    ) {
        parent::__construct($context);
        $this->bannerModel = $bannerModel;
    }

    /**
     * Execute
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        /** @var $model Banner */
        $model = $this->bannerModel;
        if (!empty($id)) {
            $model->load($id);
            try {
                if ($model->getId()) {
                    $model->delete();
                    $this->messageManager->addSuccessMessage(__('Delete Data Successful!'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }

        return $this->resultRedirectFactory->create()->setPath('magenest/banner/index');
    }
}
