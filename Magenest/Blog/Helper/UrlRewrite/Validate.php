<?php

namespace Magenest\Blog\Helper\UrlRewrite;

use Magenest\Blog\Model\Blog;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Controller\Adminhtml\Url\Rewrite;
use Magento\UrlRewrite\Model\Exception\UrlAlreadyExistsException;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

class Validate extends AbstractHelper
{
    /**
     * @var UrlFinderInterface
     */
    protected $urlFinder;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Constructor
     *
     * @param Context               $context
     * @param UrlFinderInterface    $urlFinder
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context               $context,
        UrlFinderInterface    $urlFinder,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->urlFinder = $urlFinder;
        $this->storeManager = $storeManager;
    }

    /**
     * Validate rewrite url for blog model
     *
     * @param Blog $blog
     *
     * @return void
     * @throws UrlAlreadyExistsException
     */
    public function validateBlogUrlRewrite(Blog $blog)
    {
        $stores = $this->storeManager->getStores();

        $storeIdsToPathForSave = [];
        $searchData = [
            UrlRewrite::ENTITY_TYPE => Rewrite::ENTITY_TYPE_CUSTOM,
            UrlRewrite::REQUEST_PATH => [],
        ];

        foreach ($stores as $store) {
            $urlPath = $blog->getUrlRewrite() ?? '';
            $storeIdsToPathForSave[$store->getId()] = $urlPath;
            $searchData[UrlRewrite::REQUEST_PATH][] = $urlPath;
        }

        $urlRewrites = $this->urlFinder->findAllByData($searchData);
        $exceptionData = [];

        foreach ($urlRewrites as $urlRewrite) {
            if (in_array($urlRewrite->getRequestPath(), $storeIdsToPathForSave, true)
                && isset($storeIdsToPathForSave[$urlRewrite->getStoreId()])
                && $storeIdsToPathForSave[$urlRewrite->getStoreId()] === $urlRewrite->getRequestPath()
            ) {
                $exceptionData[$urlRewrite->getUrlRewriteId()] = $urlRewrite->toArray();
            }
        }

        $urlRewrites = $this->urlFinder->findAllByData($searchData);

        if ($exceptionData) {
            throw new UrlAlreadyExistsException(
                __('URL key for specified store already exists.'),
                null,
                0,
                $exceptionData
            );
        }
    }
}
