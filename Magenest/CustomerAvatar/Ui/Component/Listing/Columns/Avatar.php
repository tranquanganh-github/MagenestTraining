<?php

namespace Magenest\CustomerAvatar\Ui\Component\Listing\Columns;

use Magenest\CustomerAvatar\Setup\Patch\Data\CustomerAttributeAvatar;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Avatar extends Column
{
    /**
     * @var UrlInterface
     */
    protected UrlInterface $urlBuilder;

    /**
     * @var Repository
     */
    protected Repository $viewFileUrl;

    /**
     * Constructor
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param Repository         $viewFileUrl
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        Repository         $viewFileUrl,
        array              $components = [],
        array              $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->viewFileUrl = $viewFileUrl;
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
            $fieldName = $this->getData('name');
            $attriCode = CustomerAttributeAvatar::CUSTOMER_ATTRIBUTE_AVATAR;
            foreach ($dataSource['data']['items'] as & $item) {
                if (!empty($item[$attriCode])) {
                    $urlBuilder = $this->urlBuilder->getUrl(
                        'customer/index/viewfile/image/' . base64_encode($item[$attriCode])
                    );
                    $imageUrl = $urlBuilder;
                    $item[$fieldName . '_src'] = $imageUrl;
                    $item[$fieldName . '_orig_src'] = $imageUrl;
                    $item[$fieldName . '_alt'] = 'Customer Avatar';
                }
            }
        }

        return $dataSource;
    }
}
