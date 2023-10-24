<?php

namespace Magenest\CustomDB\Setup\Patch\Data;

use Exception;
use Magenest\CustomDB\Model\Customer\Address\Attribute\Source\Region;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Validator\ValidateException;
use Psr\Log\LoggerInterface;

class CustomerAddressRegionsAttribute implements DataPatchInterface
{
    public const CUSTOMER_ADDRESS_ATTRIBUTE_REGION = 'vn_region';
    public const CUSTOMER_ADDRESS = 'customer_address';

    /**
     * @var ModuleDataSetupInterface
     */
    protected ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    protected EavSetupFactory $eavSetupFactory;

    /**
     * @var Config
     */
    protected Config $eavConfig;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory          $eavSetupFactory
     * @param Config                   $eavConfig
     * @param LoggerInterface          $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory          $eavSetupFactory,
        Config                   $eavConfig,
        LoggerInterface          $logger
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $moduleSetup = $this->moduleDataSetup->getConnection();
        $moduleSetup->startSetup();
        $this->addDataAttribute();
        $moduleSetup->endSetup();
    }

    /**
     * Add customer address attribute
     *
     * @return void
     */
    public function addDataAttribute()
    {
        try {
            $eavSetup = $this->eavSetupFactory->create();
            $eavSetup->addAttribute(
                self::CUSTOMER_ADDRESS,
                self::CUSTOMER_ADDRESS_ATTRIBUTE_REGION,
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'source_model' => Region::class,
                    'label' => 'Viet Nam Region',
                    'input' => 'text',
                    'required' => true,
                    'visible' => true,
                    'user_defined' => true,
                    'sort_order' => 40,
                    'position' => 40,
                    'system' => 0,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => true,
                    'is_html_allowed_on_front' => true,
                    'visible_on_front' => true
                ]
            );

            $attribute = $this->eavConfig->getAttribute(
                self::CUSTOMER_ADDRESS,
                self::CUSTOMER_ADDRESS_ATTRIBUTE_REGION
            );

            if ($attribute) {
                $attribute->setData('used_in_forms', [
                    'adminhtml_customer_address',
                    'customer_address_edit',
                    'customer_register_address'
                ]);

                $attribute->save();
            }

        } catch (LocalizedException|ValidateException|Exception $e) {
            $this->logger->critical($e);
        }
    }
}
