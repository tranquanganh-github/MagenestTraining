<?php

namespace Magenest\AddToCartSimpleProduct\Plugin\Controller\Checkout\Cart;

use Magento\Catalog\Model\ProductFactory as ProductModelFactory;
use Magento\ConfigurableProduct\Model\Product\Type\ConfigurableFactory as ConfigurableModelFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class AddPlugin
{
    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

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
     * Constructor
     *
     * @param RequestInterface $request
     * @param StoreManagerInterface $storeManager
     * @param ProductModelFactory $productModelFactory
     * @param ConfigurableModelFactory $configurableModelFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        RequestInterface         $request,
        StoreManagerInterface    $storeManager,
        ProductModelFactory      $productModelFactory,
        ConfigurableModelFactory $configurableModelFactory,
        LoggerInterface          $logger
    ) {
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->productModelFactory = $productModelFactory;
        $this->configurableModelFactory = $configurableModelFactory;
        $this->logger = $logger;
    }

    /**
     * Before plugin for execute funtion
     *
     * @return void
     */
    public function beforeExecute()
    {
        $params = $this->request->getParams();
        $productId = $params['product'];
        $productAttri = $params['super_attribute'];
        if ($productId && $productAttri) {
            /** @var $productModel \Magento\Catalog\Model\Product */
            $productModel = $this->productModelFactory->create();
            $product = $productModel->load($productId);
            /** @var $configProductModel \Magento\ConfigurableProduct\Model\Product\Type\Configurable */
            $configProductModel = $this->configurableModelFactory->create();
            $associateProduct = $configProductModel->getProductByAttributes($productAttri, $product);
            $params['product'] = $associateProduct->getId();
            $this->request->setParams($params);
        }
    }
}
