<?php

namespace Magenest\CustomDB\Setup\Patch\Data;

use Magenest\CustomerAvatar\Model\Customer\Attribute\Backend\Avatar;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Validator\ValidateException;
use Psr\Log\LoggerInterface;
use Magento\Eav\Model\Entity\Attribute\Frontend\Datetime;

class CustomerPhoneNumber implements DataPatchInterface
{
    public const CUSTOMER_ATTRIBUTE_PHONE_NUMBER = 'phone_number';

    /**
     * @var ModuleDataSetupInterface
     */
    protected ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    protected EavSetupFactory $eavSetupFactory;

    /**
     * @var Attribute
     */
    protected Attribute $attributeResource;

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
     * @param Attribute                $attributeResource
     * @param Config                   $eavConfig
     * @param LoggerInterface          $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory          $eavSetupFactory,
        Attribute                $attributeResource,
        Config                   $eavConfig,
        LoggerInterface          $logger
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeResource = $attributeResource;
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
     * Add customer attribute name avatar
     *
     * @return void
     */
    public function addDataAttribute()
    {
        try {
            $eavSetup = $this->eavSetupFactory->create();
            $eavSetup->addAttribute(
                Customer::ENTITY,
                self::CUSTOMER_ATTRIBUTE_PHONE_NUMBER,
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'Phone Number',
                    'input' => 'text',
                    'required' => false,
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

            $attributeSetId = $eavSetup->getDefaultAttributeSetId(Customer::ENTITY);
            $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Customer::ENTITY);

            $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, self::CUSTOMER_ATTRIBUTE_PHONE_NUMBER);

            if ($attribute) {
                $attribute->setData('attribute_set_id', $attributeSetId);
                $attribute->setData('attribute_group_id', $attributeGroupId);

                $attribute->setData('used_in_forms', [
                    'adminhtml_customer',
                    'customer_account_edit',
                    'customer_account_create'
                ]);

                $this->attributeResource->save($attribute);
            }

        } catch (LocalizedException|ValidateException|\Exception $e) {
            $this->logger->critical($e);
        }
    }
}
