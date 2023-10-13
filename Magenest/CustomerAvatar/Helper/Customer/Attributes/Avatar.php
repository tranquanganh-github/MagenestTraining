<?php

namespace Magenest\CustomerAvatar\Helper\Customer\Attributes;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\MediaStorage\Helper\File\Storage;

class Avatar extends AbstractHelper
{
    /**
     * @var Storage
     */
    private Storage $fileStorage;

    /**
     * @var Filesystem
     */
    private Filesystem $fileSystem;

    /**
     * @var Repository
     */
    protected Repository $viewFileUrl;

    /**
     * Constructor
     *
     * @param Context    $context
     * @param Filesystem $fileSystem
     * @param Storage    $fileStorage
     * @param Repository $viewFileUrl
     */
    public function __construct(
        Context    $context,
        Filesystem $fileSystem,
        Storage    $fileStorage,
        Repository $viewFileUrl
    ) {
        parent::__construct($context);
        $this->fileSystem = $fileSystem;
        $this->fileStorage = $fileStorage;
        $this->viewFileUrl = $viewFileUrl;
    }

    /**
     * Get the avatar of the customer is already logged in
     *
     * @param mixed $file
     *
     * @return string
     */
    public function getAvatarCurrentCustomer($file)
    {
        if (!empty($file) && $this->checkImageFile(base64_encode($file))) {
            $result = $this->_getUrl('magenest/customer/avatar/', ['image' => base64_encode($file)]);
        }

        return $result ?? '';
    }

    /**
     * Check the file is already exist in the path.
     *
     * @param mixed $file
     *
     * @return boolean
     */
    public function checkImageFile($file)
    {
        if (empty($file)) {
            return false;
        }
        $file = base64_decode($file);
        $directory = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA);
        $fileName = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER . '/' . ltrim($file, '/');
        $path = $directory->getAbsolutePath($fileName);

        return !(!$directory->isFile($fileName) && $this->fileStorage->processStorageFile($path));
    }

    /**
     * Get Directory by code
     *
     * @param string $code
     *
     * @return ReadInterface
     */
    public function getDirectoryReadByCode(string $code)
    {
        return $this->fileSystem->getDirectoryRead($code);
    }
}
