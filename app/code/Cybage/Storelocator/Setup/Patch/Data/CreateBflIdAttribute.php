<?php
/**
 * BFL Cybage_Storelocator
 *
 * @category   Cybage_Storelocator Module
 * @package    BFL Cybage_Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\Storelocator\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

/**
 */
class CreateBflIdAttribute implements DataPatchInterface, PatchRevertableInterface {

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    
    /** @var \Magento\Eav\Setup\EavSetupFactory */
    private $eavSetupFactory;

    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply() {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $attributeId = $eavSetup->getAttributeId(\Magento\Catalog\Model\Category::ENTITY, 'bfl_id');
        if(!$attributeId){
            $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'bfl_id',
                [
                    'type' => 'varchar',
                    'label' => 'BFL ID',
                    'input' => 'text',
                    'sort_order' => 333,
                    'source' => '',
                    'global' => 1,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => null,
                    'group' => 'General Information',
                    'backend' => ''
                ]
            );
        }
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies() {
        return [];
    }

    public function revert() {}

    /**
     * {@inheritdoc}
     */
    public function getAliases() {
        return [];
    }
}