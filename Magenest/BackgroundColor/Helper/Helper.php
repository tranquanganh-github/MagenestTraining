<?php

namespace Magenest\BackgroundColor\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;

class Helper extends AbstractHelper
{
    public const XML_PATH_BACKGROUND_COLOR = 'magenest_background_color/general/select_background_color';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * Constructor
     *
     * @param Context             $context
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Context             $context,
        SerializerInterface $serializer,
    ) {
        parent::__construct($context);
        $this->scopeConfig = $context->getScopeConfig();
        $this->serializer = $serializer;
    }

    /**
     * Get store config by path
     *
     * @param string $path
     *
     * @return mixed
     */
    private function getScopeConfigValueByPath(string $path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get background color config value
     *
     * @return mixed
     */
    public function getBackgroundColorScopeConfig()
    {
        $data = $this->getScopeConfigValueByPath(self::XML_PATH_BACKGROUND_COLOR);

        return $this->serializer->unserialize($data);
    }
}
