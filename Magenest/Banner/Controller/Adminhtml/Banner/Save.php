<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Exception;
use Magenest\Banner\Api\Data\BannerInterface;
use Magenest\Banner\Model\BannerRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @var BannerInterface
     */
    protected $bannerModel;

    /**
     * @var Json
     */
    protected $serialize;

    /**
     * Constructor
     *
     * @param Context          $context
     * @param LoggerInterface  $logger
     * @param ManagerInterface $eventManager
     * @param BannerInterface  $bannerModel
     * @param Json             $serialize
     */
    public function __construct(
        Context          $context,
        LoggerInterface  $logger,
        ManagerInterface $eventManager,
        BannerInterface  $bannerModel,
        Json             $serialize
    ) {
        parent::__construct($context);
        $this->logger = $logger;
        $this->eventManager = $eventManager;
        $this->bannerModel = $bannerModel;
        $this->serialize = $serialize;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if (!empty($data)) {
            try {
                $model = $this->bannerModel;
                if ($data['entity_id']) {
                    $model->load($data['entity_id']);
                }
                $model->setName($data['name']);
                $model->setStatus($data['is_active']);
                $model->setTitle($data['title'] ?? '');
                $model->setText($data['text'] ?? '');
                if ($this->getUploadedImageName($data['image']) !== null) {
                    $data['image'] = $this->serialize->serialize($data['image']);
                    $model->setImage($data['image']);
                }
                $model->setUrlPage($data['url_page'] ?? '');
                $model->save();

                $this->eventManager->dispatch(
                    'magenest_banner_after_save',
                    [
                        'data_object' => $model,
                        'request_params' => $data
                    ]
                );

                $this->messageManager->addSuccessMessage(__('You saved the new banner'));
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving data. Please review the error log.')
                );
                $this->logger->critical($e);
            }
        } else {
            $this->messageManager->addErrorMessage(
                __('Something went wrong while saving.')
            );
        }
        $this->_redirect('magenest/banner/index');
    }

    /**
     * Gets image name from $value array.
     *
     * Will return empty string in a case when $value is not an array.
     *
     * @param array $value Attribute value
     *
     * @return string
     */
    private function getUploadedImageName($value)
    {
        if (is_array($value) && isset($value[0]['name'])) {
            return $value[0]['name'];
        }

        return '';
    }
}
