<?php

namespace Magenest\Banner\Block\Banner;

use Magenest\Banner\Api\Data\BannerInterface;
use Magenest\Banner\Model\ResourceModel\Banner\Collection;
use Magenest\Banner\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;
use Magenest\Banner\Ui\Component\Listing\Column\Status;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template;

class Index extends Template
{
    /**
     * @var BannerInterface
     */
    protected $banner;

    /**
     * @var BannerCollectionFactory
     */
    protected $bannerCollectionFactory;

    /**
     * @var Json
     */
    protected $serialize;

    public function __construct(
        Template\Context        $context,
        BannerInterface         $banner,
        BannerCollectionFactory $bannerCollectionFactory,
        Json                    $serialize,
        array                   $data = []
    ) {
        parent::__construct($context, $data);
        $this->banner = $banner;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->serialize = $serialize;
    }

    /**
     * Get all banner available
     *
     * @return array
     */
    public function getBanner()
    {
        /** @var $collection Collection */
        $collection = $this->bannerCollectionFactory->create();
        $collection->addFieldToFilter(
            BannerInterface::STATUS,
            [
                'eq' => Status::STATUS_ENABLED_VALUE
            ]
        );

        $collectionData = $collection->getData();
        $data = [];

        if ($collectionData) {
            foreach ($collectionData as & $item) {
                if ($item['image']) {
                    $item['image'] = $this->getBannerImage($item['image']);
                }

                $data[] = [
                    'name' => $item['name'],
                    'image' => isset($item['image'][0]) ? $item['image'][0]['url'] : '',
                    'title' => $item['title']
                ];
            }
        }

        return $data;
    }

    /**
     * Un-serialize banner image
     *
     * @param string $image
     *
     * @return array|bool|float|int|mixed|string|null
     */
    public function getBannerImage($image)
    {
        if (!$image) {
            return [];
        }

        return $this->serialize->unserialize($image);
    }
}
