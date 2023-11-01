<?php

namespace Magenest\ShippingDate\Model;

use Magenest\ShippingDate\Api\Data\ShippingDateInterface;
use Magenest\ShippingDate\Api\ShippingDateRepositoryInterface;
use Magenest\ShippingDate\Model\ResourceModel\ShippingDate\Collection;
use Magenest\ShippingDate\Model\ResourceModel\ShippingDate\CollectionFactory;
use Magenest\ShippingDate\Model\ShippingDate as Model;
use Magenest\ShippingDate\Model\ShippingDateFactory as ModelFactory;

class ShippingDateRepository implements ShippingDateRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ShippingDateFactory
     */
    protected $modelFactory;

    /**
     * Constructor
     *
     * @param CollectionFactory   $collectionFactory
     * @param ShippingDateFactory $modelFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ModelFactory      $modelFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->modelFactory = $modelFactory;
    }

    /**
     * @inheritDoc
     */
    public function loadByQuoteId(int $quoteId)
    {
        if ($quoteId) {
            /** @var $collection Collection */
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter(ShippingDateInterface::QUOTE_ID, ['eq' => $quoteId]);
            $shippingDate = $collection->getData();
            foreach ($shippingDate as $item) {
                if (isset($item['entity_id'])) {
                    /** @var $model Model */
                    $model = $this->modelFactory->create();
                    $model->load($item['entity_id']);
                    if ($model->getId()) {
                        return $model;
                    }
                }
            }
        }

        return null;
    }
}
