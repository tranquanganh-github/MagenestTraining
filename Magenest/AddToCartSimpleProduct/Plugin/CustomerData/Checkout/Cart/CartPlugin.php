<?php

namespace Magenest\AddToCartSimpleProduct\Plugin\CustomerData\Checkout\Cart;

use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory as ProductModelFactory;
use Magento\Checkout\CustomerData\Cart;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\ConfigurableProduct\Model\Product\Type\ConfigurableFactory as ConfigurableModelFactory;
use Magento\Framework\App\RequestInterface;
use Psr\Log\LoggerInterface;

class CartPlugin
{
    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var ProductModelFactory
     */
    protected ProductModelFactory $productModelFactory;

    /**
     * @var ConfigurableModelFactory
     */
    protected ConfigurableModelFactory $configurableModelFactory;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var Image
     */
    protected Image $imageHelper;

    /**
     * Constructor
     *
     * @param RequestInterface         $request
     * @param ProductModelFactory      $productModelFactory
     * @param ConfigurableModelFactory $configurableModelFactory
     * @param Image                    $imageHelper
     * @param LoggerInterface          $logger
     */
    public function __construct(
        RequestInterface         $request,
        ProductModelFactory      $productModelFactory,
        ConfigurableModelFactory $configurableModelFactory,
        Image                    $imageHelper,
        LoggerInterface          $logger
    ) {
        $this->request = $request;
        $this->productModelFactory = $productModelFactory;
        $this->configurableModelFactory = $configurableModelFactory;
        $this->imageHelper = $imageHelper;
        $this->logger = $logger;
    }

    /**
     * After getSectionData
     *
     * @param Cart  $subject
     * @param array $result
     *
     * @return array $result
     */
    public function afterGetSectionData(Cart $subject, array $result): array
    {
        /** @var $productModel Product */
        $productModel = $this->productModelFactory->create();
        /** @var $configProductModel Configurable */
        $configProductModel = $this->configurableModelFactory->create();
        foreach ($result['items'] as & $item) {
            $productId = $item['product_id'];
            $productAttri = $this->getProductAttributeValue($item['options']);
            if ($productId && !empty($productAttri)) {
                $product = $productModel->load($productId);
                $associateProduct = $configProductModel->getProductByAttributes($productAttri, $product);
                if ($associateProduct) {
                    $imageHelper = $this->imageHelper->init($associateProduct, 'mini_cart_product_thumbnail');
                    $item['product_name'] = $associateProduct->getName();
                    $item['product_image']['src'] = $imageHelper->getUrl();
                }
            }
        }
        unset($item);

        return $result;
    }

    /**
     * Get product attribute
     *
     * @param array $productAtrri
     *
     * @return array
     */
    public function getProductAttributeValue(array $productAtrri)
    {
        if (!empty($productAtrri)) {
            foreach ($productAtrri as $option) {
                $key[] = $option['option_id'];
                $value[] = $option['option_value'];
            }
        }

        return isset($key, $value) ? array_combine($key, $value) : [];
    }
}
