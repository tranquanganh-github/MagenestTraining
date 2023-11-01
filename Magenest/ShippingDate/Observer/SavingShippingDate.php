<?php

namespace Magenest\ShippingDate\Observer;

use Exception;
use Magenest\ShippingDate\Model\ResourceModel\ShippingDate;
use Magenest\ShippingDate\Model\ResourceModel\ShippingDateFactory as ShippingDateResourceModel;
use Magenest\ShippingDate\Model\ShippingDateFactory as ShippingDateModel;
use Magenest\ShippingDate\Model\ShippingDateRepository;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class SavingShippingDate implements ObserverInterface
{
    /**
     * @var ShippingDateModel
     */
    protected $modelFactory;
    /**
     * @var ShippingDateResourceModel
     */
    protected $resourceModelFactory;

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var ShippingDateRepository
     */
    protected $shippingDateRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param ShippingDateModel         $modelFactory
     * @param ShippingDateResourceModel $resourceModelFactory
     * @param CheckoutSession           $checkoutSession
     * @param ShippingDateRepository    $shippingDateRepository
     * @param LoggerInterface           $logger
     */
    public function __construct(
        ShippingDateModel         $modelFactory,
        ShippingDateResourceModel $resourceModelFactory,
        CheckoutSession           $checkoutSession,
        ShippingDateRepository    $shippingDateRepository,
        LoggerInterface           $logger
    ) {
        $this->modelFactory = $modelFactory;
        $this->resourceModelFactory = $resourceModelFactory;
        $this->checkoutSession = $checkoutSession;
        $this->shippingDateRepository = $shippingDateRepository;
        $this->logger = $logger;
    }

    /**
     * Execute
     *
     * @param Observer $observer
     *
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $eventData = $observer->getEvent();
        if ($eventData) {
            $param = $eventData->getRequest()->getParams();
            $quote = $this->checkoutSession->getQuote();
            if ($quote && $param['magenest-shipping-date-type']) {
                $quoteId = $quote->getId();
                $quoteStatus = $quote->getIsActive();
                if ($quoteId && isset($param['magenest-shipping-date'])) {
                    try {
                        $shippingDate = $this->shippingDateRepository->loadByQuoteId($quoteId);
                        $model = $shippingDate ?? $this->modelFactory->create();
                        $model->setQuoteId($quoteId);
                        $model->setStatus($quoteStatus ?? false);
                        $model->setShippingDate($param['magenest-shipping-date']);
                        /** @var $resourceModel ShippingDate */
                        $resourceModel = $this->resourceModelFactory->create();
                        $resourceModel->save($model);
                    } catch (AlreadyExistsException $e) {
                        $this->logger->debug($e->getMessage());
                    } catch (Exception $e) {
                        $this->logger->error($e);
                    }
                }
            }
        }
    }
}
