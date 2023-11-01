<?php

namespace Magenest\Banner\Model\Banner;

use Magenest\Banner\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\Serialize\Serializer\Json;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var BannerCollectionFactory
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var Json
     */
    protected $serialize;

    /**
     * Constructor
     *
     * @param string                  $name
     * @param string                  $primaryFieldName
     * @param string                  $requestFieldName
     * @param BannerCollectionFactory $bannerCollectionFactory
     * @param Json                    $serialize
     * @param array                   $meta
     * @param array                   $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        BannerCollectionFactory $bannerCollectionFactory,
        Json $serialize,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $bannerCollectionFactory->create();
        $this->serialize = $serialize;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = [];
        /** @var $item \Magenest\Banner\Model\Banner */
        foreach ($items as $item) {
            $data = $item->getData();
            if (isset($data['image'])) {
                try {
                    $data['image'] = $this->serialize->unserialize($item->getImage());
                } catch (\Exception $e) {
                    $data['image'] = '';
                }
            }
            $this->loadedData[$item->getId()] = $data;
        }

        return $this->loadedData;
    }
}
