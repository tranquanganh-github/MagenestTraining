<?php

namespace Magenest\Banner\Ui\Component\Listing\Column;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Image extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Repository
     */
    protected $viewFileUrl;

    /**
     * @var Json
     */
    protected $serialize;

    /**
     * Constructor
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param Repository         $viewFileUrl
     * @param Json               $serialize
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        Repository         $viewFileUrl,
        Json               $serialize,
        array              $components = [],
        array              $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->viewFileUrl = $viewFileUrl;
        $this->serialize = $serialize;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getName();
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['image']) {
                    try {
                        $dataImage = $this->serialize->unserialize($item['image']);
                        $item[$fieldName . '_src'] = $dataImage[0]['url'];
                        $item[$fieldName . '_orig_src'] = $dataImage[0]['url'];
                    } catch (\Exception $e) {
                        $item['image'] = '';
                    }
                }
            }
        }

        return $dataSource;
    }
}
