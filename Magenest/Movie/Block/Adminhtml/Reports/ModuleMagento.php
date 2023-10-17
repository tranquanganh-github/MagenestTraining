<?php

namespace Magenest\Movie\Block\Adminhtml\Reports;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Magento\Framework\Module\FullModuleList;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory as CreditmemoCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory as InvoiceCollectionFactory;

class ModuleMagento extends Template
{
    /**
     * @var FullModuleList
     */
    protected $fullModuleList;

    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;
    protected CustomerCollectionFactory $customerCollectionFactory;
    protected OrderCollectionFactory $orderCollectionFactory;
    protected InvoiceCollectionFactory $invoiceCollectionFactory;
    protected CreditmemoCollectionFactory $creditmemoCollectionFactory;

    public function __construct(
        Template\Context            $context,
        FullModuleList              $fullModuleList,
        ProductCollectionFactory    $productCollectionFactory,
        CustomerCollectionFactory   $customerCollectionFactory,
        OrderCollectionFactory      $orderCollectionFactory,
        InvoiceCollectionFactory    $invoiceCollectionFactory,
        CreditmemoCollectionFactory $creditmemoCollectionFactory,
        array                       $data = []
    ) {
        parent::__construct($context, $data);
        $this->fullModuleList = $fullModuleList;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->invoiceCollectionFactory = $invoiceCollectionFactory;
        $this->creditmemoCollectionFactory = $creditmemoCollectionFactory;
    }

    /**
     * Get all module install
     *
     * @return int|null
     */
    public function getAllModuleInstall()
    {
        $listModule = $this->fullModuleList->getAll();
        if (!empty($listModule)) {
            return count($listModule);
        }

        return null;
    }

    public function getAllDataMagento()
    {
        $productCollection = $this->productCollectionFactory->create();
        $customerCollection = $this->customerCollectionFactory->create();
        $orderCollection = $this->orderCollectionFactory->create();
        $invoiceCollection = $this->invoiceCollectionFactory->create();
        $creditmemoCollection = $this->creditmemoCollectionFactory->create();

        return [
            'products' => $productCollection->count(),
            'customers' => $customerCollection->count(),
            'orders' => $orderCollection->count(),
            'invoices' => $invoiceCollection->count(),
            'creditmemo' => $creditmemoCollection->count()
        ];
    }
}
