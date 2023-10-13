<?php

namespace Magenest\CustomerAvatar\Controller\Customer;

use Exception;
use Magenest\CustomerAvatar\Helper\Customer\Attributes\Avatar as CustomerAvatarHelper;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Filesystem\Io\File as FileIo;
use Magento\Framework\Url\DecoderInterface;

class Avatar extends Action
{
    /**
     * @var RawFactory
     */
    protected RawFactory $resultRawFactory;

    /**
     * @var DecoderInterface
     */
    protected DecoderInterface $urlDecoder;

    /**
     * @var FileIo
     */
    private FileIo $ioFile;

    /**
     * @var CustomerAvatarHelper
     */
    protected CustomerAvatarHelper $customerAvatarHelper;

    /**
     * @param Context              $context
     * @param RawFactory           $resultRawFactory
     * @param DecoderInterface     $urlDecoder
     * @param CustomerAvatarHelper $customerAvatarHelper
     * @param FileIo|null          $ioFile
     */
    public function __construct(
        Context              $context,
        RawFactory           $resultRawFactory,
        DecoderInterface     $urlDecoder,
        CustomerAvatarHelper $customerAvatarHelper,
        FileIo               $ioFile = null
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->urlDecoder = $urlDecoder;
        $this->customerAvatarHelper = $customerAvatarHelper;
        $this->ioFile = $ioFile ?? ObjectManager::getInstance()->get(FileIo::class);
    }

    /**
     * View action
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @return Raw
     * @throws FileSystemException
     * @throws NotFoundException
     */
    public function execute()
    {
        $image = $this->getRequest()->getParam('image');
        if ($image) {
            $imageFile = $this->urlDecoder->decode($image);
        } else {
            throw new NotFoundException(__('Page not found.'));
        }
        $directory = $this->customerAvatarHelper->getDirectoryReadByCode(DirectoryList::MEDIA);
        $imageName = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER . '/' . ltrim($imageFile, '/');
        $path = $directory->getAbsolutePath($imageName);

        if (!$this->customerAvatarHelper->checkImageFile(base64_encode($imageFile))) {
            throw new NotFoundException(__('Page not found.'));
        }

        $extension = $this->ioFile->getPathInfo($path);
        $contentType = match (strtolower($extension['extension'])) {
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'png' => 'image/png',
            default => 'application/octet-stream',
        };
        // check image
        $stat = $directory->stat($imageName);
        $contentLength = $stat['size'];
        $contentModify = $stat['mtime'];

        /** @var $resultRaw Raw */
        $resultRaw = $this->resultRawFactory->create();
        $resultRaw->setHttpResponseCode(200)
            ->setHeader('Pragma', 'public', true)
            ->setHeader('Content-type', $contentType, true)
            ->setHeader('Content-Length', $contentLength)
            ->setHeader('Last-Modified', date('r', $contentModify));

        return $resultRaw->setContents($directory->readFile($imageName));
    }
}
