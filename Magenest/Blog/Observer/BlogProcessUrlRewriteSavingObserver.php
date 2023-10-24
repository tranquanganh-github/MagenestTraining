<?php

namespace Magenest\Blog\Observer;

use Magenest\Blog\Api\Data\BlogInterface;
use Magenest\Blog\Model\Blog;
use Magenest\Blog\Model\BlogUrlPathGenerator;
use Magento\CatalogUrlRewrite\Model\Products\AppendUrlRewritesToProducts;
use Magento\CatalogUrlRewrite\Service\V1\StoreViewService;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreResolver\GetStoresListByWebsiteIds;
use Magento\UrlRewrite\Controller\Adminhtml\Url\Rewrite;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Magento\UrlRewrite\Model\UrlRewrite;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Psr\Log\LoggerInterface;

class BlogProcessUrlRewriteSavingObserver implements ObserverInterface
{
    /**
     * @var UrlPersistInterface
     */
    private $urlPersist;

    /**
     * @var AppendUrlRewritesToProducts
     */
    private $appendRewrites;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var GetStoresListByWebsiteIds
     */
    private $getStoresList;

    /**
     * @var StoreViewService
     */
    private $storeViewService;

    /**
     * @var UrlRewriteFactory
     */
    private $urlRewriteFactory;

    /**
     * @var BlogUrlPathGenerator
     */
    protected $blogUrlPathGenerator;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param UrlPersistInterface         $urlPersist
     * @param AppendUrlRewritesToProducts $appendRewrites
     * @param ScopeConfigInterface        $scopeConfig
     * @param GetStoresListByWebsiteIds   $getStoresList
     * @param StoreViewService            $storeViewService
     * @param UrlRewriteFactory           $urlRewriteFactory
     * @param BlogUrlPathGenerator        $blogUrlPathGenerator
     * @param LoggerInterface             $logger
     */
    public function __construct(
        UrlPersistInterface         $urlPersist,
        AppendUrlRewritesToProducts $appendRewrites,
        ScopeConfigInterface        $scopeConfig,
        GetStoresListByWebsiteIds   $getStoresList,
        StoreViewService            $storeViewService,
        UrlRewriteFactory           $urlRewriteFactory,
        BlogUrlPathGenerator        $blogUrlPathGenerator,
        LoggerInterface             $logger
    ) {
        $this->urlPersist = $urlPersist;
        $this->appendRewrites = $appendRewrites;
        $this->scopeConfig = $scopeConfig;
        $this->getStoresList = $getStoresList;
        $this->storeViewService = $storeViewService;
        $this->urlRewriteFactory = $urlRewriteFactory;
        $this->blogUrlPathGenerator = $blogUrlPathGenerator;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        /** @var $blog Blog */
        $blog = $observer->getObject();
        if ($blog->getUrlRewrite()) {
            if ($this->isNeedUpdateRewrites($blog)) {
                $this->deleteObsoleteRewrites($blog);
            }
            try {
                /** @var $urlRewriteModel UrlRewrite */
                $urlRewriteModel = $this->urlRewriteFactory->create();
                $urlRewriteModel->setEntityType(Rewrite::ENTITY_TYPE_CUSTOM)
                    ->setRequestPath($blog->getUrlRewrite())
                    ->setTargetPath($this->blogUrlPathGenerator->getPathUrl($blog))
                    ->setRedirectType(0)
                    ->setStoreId(1);
                $urlRewriteModel->save();
            } catch (\Exception $e) {
                $this->logger->critical(__($e->getMessage()));
            }
        }
    }

    /**
     * Is product rewrites need to be updated
     *
     * @param Blog $blog
     *
     * @return bool
     */
    private function isNeedUpdateRewrites(Blog $blog): bool
    {
        return ($blog->dataHasChangedFor(BlogInterface::URL_REWRITE));
    }

    /**
     * Remove obsolete Url rewrites
     *
     * @param Blog $blog
     */
    private function deleteObsoleteRewrites(Blog $blog): void
    {
        //do not perform redundant delete request for new product
        if ($blog->getOrigData('entity_id') === null) {
            return;
        }

        $origBlogUrlRewrite = $blog->getOrigData(BlogInterface::URL_REWRITE);
        if ($origBlogUrlRewrite) {
            $this->urlPersist->deleteByData(
                [
                    \Magento\UrlRewrite\Service\V1\Data\UrlRewrite::ENTITY_TYPE => Rewrite::ENTITY_TYPE_CUSTOM,
                    \Magento\UrlRewrite\Service\V1\Data\UrlRewrite::REQUEST_PATH => $origBlogUrlRewrite
                ]
            );
        }
    }
}
