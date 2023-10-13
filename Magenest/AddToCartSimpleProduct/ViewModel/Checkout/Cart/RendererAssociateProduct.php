<?php

namespace Magenest\AddToCartSimpleProduct\ViewModel\Checkout\Cart;

use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\ConfigurableProduct\Model\Product\Type\ConfigurableFactory as ConfigurableModelFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class RendererAssociateProduct implements ArgumentInterface
{
    /**
     * @var ConfigurableModelFactory
     */
    protected ConfigurableModelFactory $configurableModelFactory;

    /**
     * Constructor
     *
     * @param ConfigurableModelFactory $configurableModelFactory
     */
    public function __construct(
        ConfigurableModelFactory $configurableModelFactory,
    ) {
        $this->configurableModelFactory = $configurableModelFactory;
    }

    /**
     * Get associate product by attributes
     *
     * @param Product $product
     * @param array   $productAttri
     *
     * @return Product|null
     */
    public function getAssociateProduct(Product $product, array $productAttri)
    {
        if (empty($productAttri)) {
            return null;
        }
        $options = $this->getProductAttributeValue($productAttri);

        /** @var $configModel Configurable */
        $configModel = $this->configurableModelFactory->create();

        return !empty($options) ? $configModel->getProductByAttributes($options, $product) : null;
    }

    /**
     * Get product attribute
     *
     * @param array $productAtrri
     *
     * @return array
     */
    private function getProductAttributeValue(array $productAtrri)
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
