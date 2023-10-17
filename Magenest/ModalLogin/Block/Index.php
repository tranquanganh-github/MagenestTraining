<?php

namespace Magenest\ModalLogin\Block;

use Magento\Customer\Model\Form;
use Magento\Customer\Model\Url;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Http\Context as HttpContext;

class Index extends Template
{
    /**
     * @var Url
     */
    protected $customerUrl;

    /**
     * @var HttpContext
     */
    protected $httpContext;

    /**
     * Constructor
     *
     * @param Context     $context
     * @param HttpContext $httpContext
     * @param Url         $customerUrl
     * @param array       $data
     */
    public function __construct(
        Template\Context $context,
        HttpContext      $httpContext,
        Url              $customerUrl,
        array            $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerUrl = $customerUrl;
        $this->httpContext = $httpContext;
    }

    /**
     * Retrieve form posting url
     *
     * @return string
     */
    public function getPostActionUrl()
    {
        return $this->customerUrl->getLoginPostUrl();
    }

    /**
     * Retrieve sign out url
     *
     * @return string
     */
    public function getSignoutActionUrl()
    {
        return $this->customerUrl->getLogoutUrl();
    }

    /**
     * Check if autocomplete is disabled on storefront
     *
     * @return bool
     */
    public function isAutocompleteDisabled()
    {
        return (bool)!$this->_scopeConfig->getValue(
            Form::XML_PATH_ENABLE_AUTOCOMPLETE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrieve password forgotten url
     *
     * @return string
     */
    public function getForgotPasswordUrl()
    {
        return $this->customerUrl->getForgotPasswordUrl();
    }

    /**
     * Check customer login
     *
     * @return mixed|null
     */
    public function isLogin()
    {
        return $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }
}
