<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner\Image;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Upload extends Action implements HttpPostActionInterface
{
    public const PATH_MAGENEST_IMAGE_DIR = 'magenest/image';

    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Database
     */
    protected $coreFileStorageDatabase;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param Context               $context
     * @param UploaderFactory       $uploaderFactory
     * @param Filesystem            $filesystem
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface       $logger
     * @param Database              $coreFileStorageDatabase
     */
    public function __construct(
        Action\Context        $context,
        UploaderFactory       $uploaderFactory,
        Filesystem            $filesystem,
        StoreManagerInterface $storeManager,
        LoggerInterface       $logger,
        Database              $coreFileStorageDatabase
    ) {
        parent::__construct($context);
        $this->filesystem = $filesystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * Upload file controller action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $files = $this->getRequest()->getFiles();

        if (isset($files['image'])) {
            $background['icon'] = $files['image'];
            try {
                $result = $this->saveBackground($background['icon']);
                $result['cookie'] = [
                    'name' => $this->_getSession()->getName(),
                    'value' => $this->_getSession()->getSessionId(),
                    'lifetime' => $this->_getSession()->getCookieLifetime(),
                    'path' => $this->_getSession()->getCookiePath(),
                    'domain' => $this->_getSession()->getCookieDomain(),
                ];
            } catch (Exception $e) {
                $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
            }
        }

        if (empty($result)) {
            $result = ['error' => 'Image not found'];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }

    /**
     * Get file path
     *
     * @param string $path
     * @param string $imageName
     *
     * @return string
     */
    public function getFilePath($path, $imageName)
    {
        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }

    /**
     * Save background
     *
     * @param string $files
     *
     * @return array
     * @throws Exception
     * @throws LocalizedException
     */
    public function saveBackground($files)
    {
        $path = $this->filesystem
            ->getDirectoryRead(DirectoryList::MEDIA)
            ->getAbsolutePath(self::PATH_MAGENEST_IMAGE_DIR);

        $uploader = $this->uploaderFactory->create(['fileId' => $files]);
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif']);
        $uploader->setAllowRenameFiles(true);

        $result = $uploader->save($path);

        if (!$result) {
            throw new LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        /**
         * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
         */
        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['path'] = str_replace('\\', '/', $path);
        $result['url'] = $this->storeManager
                ->getStore()
                ->getBaseUrl(
                    UrlInterface::URL_TYPE_MEDIA
                ) . $this->getFilePath(self::PATH_MAGENEST_IMAGE_DIR, $result['file']);
        $result['name'] = $result['file'];

        if (isset($result['file'])) {
            try {
                $relativePath = rtrim(self::PATH_MAGENEST_IMAGE_DIR, '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (Exception $e) {
                $this->logger->critical($e);
                throw new LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }

        return $result;
    }
}
