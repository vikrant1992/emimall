<?php
/**
 * BFL Cybage_Generic
 *
 * @category   Cybage_Generic Module
 * @package    BFL Cybage_Generic
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\Generic\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Cms\Model\BlockFactory;

class CreateNewConnectivityAttribute implements DataPatchInterface {

    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    /** @var  BlockFactory */
    private $blockFactory;
    
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        BlockFactory $blockFactory
            
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $attributeSets = ["Smartphones","Tablets","Laptops"];
        $attributeGroup = "Connectivity";
        /** @var EavSetup $eavSetup */
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'connectivity_new', [
            'type' => 'int',
            'backend' => '',
            'frontend' => '',
            'label' => 'Connectivity',
            'input' => 'select',
            'class' => '',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Table',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ]);
        
        $attributeId = $eavSetup->getAttributeId(\Magento\Catalog\Model\Product::ENTITY, 'connectivity_new');
        $attributeSortOrder = 1;
        
        foreach($attributeSets as $attributeSet) {
            $attributeSetId = (int) $eavSetup->getAttributeSet(\Magento\Catalog\Model\Product::ENTITY, $attributeSet, 'attribute_set_id');
            $attributeGroupCode = $this->convertToAttributeGroupCode($attributeGroup);
            $groupData = $eavSetup->getAttributeGroupByCode(
                \Magento\Catalog\Model\Product::ENTITY,
                $attributeSetId,
                $attributeGroupCode
            );
            if (isset($groupData['attribute_group_id'])) {
                $attributeGroupId = $groupData['attribute_group_id'];
            }
            /* Map attribute to attribute group */
            if ($attributeId > 0 && $attributeGroupId > 0) {
                $eavSetup->addAttributeToGroup(
                        \Magento\Catalog\Model\Product::ENTITY,
                        $attributeSetId,
                        $attributeGroupId,
                        'connectivity_new',
                        $attributeSortOrder
                );
                $attributeSortOrder++;
            }
        }
        $this->moduleDataSetup->getConnection()->endSetup();
    }
    
    /**
     * @param string $groupName
     * @return string
     * @since 100.1.0
     */
    public function convertToAttributeGroupCode($groupName)
    {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($groupName)), '-');
    }
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}