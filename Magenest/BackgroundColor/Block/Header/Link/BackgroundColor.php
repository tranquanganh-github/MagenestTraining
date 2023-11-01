<?php

namespace Magenest\BackgroundColor\Block\Header\Link;

use Magenest\BackgroundColor\Helper\Helper;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class BackgroundColor extends Template
{
    /**
     * @var Helper
     */
    protected $helper;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Helper  $helper
     * @param array   $data
     */
    public function __construct(
        Template\Context $context,
        Helper           $helper,
        array            $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
    }

    /**
     * Get background color store config value
     *
     * @return mixed
     */
    public function getBackgroundColorConfigValue()
    {
        return $this->helper->getBackgroundColorScopeConfig();
    }
}
