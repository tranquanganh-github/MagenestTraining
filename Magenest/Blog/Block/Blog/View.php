<?php

namespace Magenest\Blog\Block\Blog;

use Magenest\Blog\Model\Blog;
use Magenest\Blog\Model\BlogRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class View extends Template
{
    /**
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * Constructor
     *
     * @param Context        $context
     * @param BlogRepository $blogRepository
     * @param array          $data
     */
    public function __construct(
        Template\Context $context,
        BlogRepository   $blogRepository,
        array            $data = []
    ) {
        parent::__construct($context, $data);
        $this->blogRepository = $blogRepository;
    }

    /**
     * Get Blog
     *
     * @return Blog|null
     * @throws NoSuchEntityException
     */
    public function getBlog()
    {
        $blogId = $this->_request->getParam('id');
        if ($blogId) {
            return $this->blogRepository->getById($blogId);
        }

        return null;
    }
}
