<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Exception;
use Magenest\Movie\Model\MovieFactory as MovieModelFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var MovieModelFactory
     */
    protected MovieModelFactory $movieModelFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param LoggerInterface $logger
     * @param MovieModelFactory $movieModelFactory
     */
    public function __construct(
        Context           $context,
        LoggerInterface   $logger,
        MovieModelFactory $movieModelFactory,
    ) {
        parent::__construct($context);
        $this->logger = $logger;
        $this->movieModelFactory = $movieModelFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if (!empty($data)) {
            try {
                /** @var $model \Magenest\Movie\Model\Movie */
                $model = $this->movieModelFactory->create();
                $model->setDataBeforeSave($data);
                $model->save();
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->logger->critical($e);
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
        $this->messageManager->addSuccessMessage(__('You saved the new movie'));
        $this->_redirect('magenest/index/movie');
    }
}
