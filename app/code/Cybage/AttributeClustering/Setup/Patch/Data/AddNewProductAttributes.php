<?php
/**
 * BFL AttributeClustering
 *
 * @category   Cybage AttributeClustering Module
 * @package    BFL AttributeClustering
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\AttributeClustering\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Psr\Log\LoggerInterface;

class AddNewProductAttributes implements DataPatchInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    /** @var arrNewProductAttrs */
    private $arrNewProductAttrs;

    /** @var arrMappedAttrCodes */
    private $arrMappedAttrCodes;

    /** @var attributeSetFactory */
    private $attributeSetFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\View\DesignInterface $designInterface,
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;

        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->designInterface = $designInterface;

        $this->arrNewProductAttrs = array(
            "Geyser"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Capacity"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Mount Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Star Rating"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Suitable For"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Performance"=>array(
                    "Rated Pressure"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Temperature Range"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Adjustable Thermostat"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Earth Leakage Circuit Breaker"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Thermal Cutoff"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Heating Element"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Multi Function Valve"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Performance Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Water Flow Rate"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Body"=>array(
                    "Body Material"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Tank Material"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Features"=>array(
                    "Indicators"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Timer"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Automatic Shut Off"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Adjustable Temperature Knob"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Fusible Valve"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Rust Resistant"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Fire Retardant Cable"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Heating Time"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Power"=>array(
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Other Power Features"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Dimensions"=>array(
                    "Width"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Height"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Depth"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Air Coolers"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "AC Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Capacity in Tons"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Cooling Capacity"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Number"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Body & Design"=>array(
                    "Evaporator Fin Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Condenser Fin Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Stepped Louvers"=>array("Filterable"=>"n","Comparable"=>"y"),
                ),
                "Features"=>array(
                    "Cooling and Heating"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Operating Modes"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Technology Used"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Dust Filter"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Panel Display"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Indoor Temperature Indicator"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Cooling Coverage Area"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Turbo Mode"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Air Swing"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Dehumidification"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Anti Bacteria Filter"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Active Carbon Filter"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Deodorizing Filter"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Restart"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Sleep Mode"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Memory Feature"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Self Diagnosis"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Emergency Operational Button"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Operating Current"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Timer"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Power"=>array(
                    "Energy Rating"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "BEE Rating"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "BEE Rating Year"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Product Dimensions"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Indoor Weight (kg)"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Outdoor Weight (kg)"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Noise"=>array(
                    "Indoor Noise Level"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Services"=>array(
                    "Covered in Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Not Covered in warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Warranty Service Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Installation"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "In The Box"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y")
                )
            ),
            "Freezer"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Number"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Capacity"=>array(
                    "Capacity"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Body"=>array(
                    "Lid Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Door Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Compartments"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Features"=>array(
                    "Lock Present"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Inbuilt Lighting"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Defrost Water Drain Present"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Defrost Type"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Power"=>array(
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Dimensions (WxDxH)"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y")
                )
            ),
            "Smartphones"=>array(
                "General"=>array(
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Weight In GMs"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Series"=>array("Filterable"=>"n","Comparable"=>"y"),
                ),
                "Processor & OS"=>array(
                    "Processor"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Others"=>array(
                    "New" => array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        /* Update sku validation*/
        $eavSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, 'sku', 'frontend_class', 'validate-length maximum-length-255');

        /* Get product entity type id */
        $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);

        $attributeSetSortOrder = 1;
        foreach ($this->arrNewProductAttrs as $attributeSet => $arrAttributeGroup) {
            /* Get attribute set id by attribute set name */
            $attributeSetId = (int)$eavSetup->getAttributeSet($entityTypeId, $attributeSet, 'attribute_set_id');

            if ($attributeSetId == 0) {
                /* Create new attribute set */
                $attributeSetObj = $this->attributeSetFactory->create();
                $defaultAttributeSetId = (int)$eavSetup->getDefaultAttributeSetId($entityTypeId);
                $data = [
                    'attribute_set_name' => $attributeSet, //attribute set name
                    'entity_type_id' => $entityTypeId,
                    'sort_order' => $attributeSetSortOrder,
                ];
                $attributeSetObj->setData($data);
                $attributeSetObj->validate();
                $attributeSetObj->save();
                $attributeSetObj->initFromSkeleton($defaultAttributeSetId)->save(); // based on default attribute set

                $this->logger->info('New Attribute Set Created');
                $attributeSetId = (int)$eavSetup->getAttributeSet($entityTypeId, $attributeSet, 'attribute_set_id');
            }
            $this->logger->info('Attribute Set Id = '.$attributeSetId);

            $attributeGroupSortOrder = 65;
            foreach ($arrAttributeGroup as $attributeGroup => $arrAttributes) {
                /* Get attribute group id by attribute group name */
                $attributeGroupId = 0;

                $attributeGroupCode = $this->convertToAttributeGroupCode($attributeGroup);
                $groupData = $eavSetup->getAttributeGroupByCode($entityTypeId, $attributeSetId, $attributeGroupCode);
                if (isset($groupData['attribute_group_id'])) {
                    $attributeGroupId = $groupData['attribute_group_id'];
                }
                
                if ($attributeGroupId == 0) {
                    /* Create new attribute group under set */
                    if ($attributeGroupCode == "general") {
                        $defaultAttributeGroupId = $eavSetup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

                        if ($defaultAttributeGroupId > 0) {
                            $eavSetup->updateAttributeGroup($entityTypeId, $attributeSetId, $defaultAttributeGroupId, 'default_id', 0);
                        }
                    }

                    $eavSetup->addAttributeGroup($entityTypeId, $attributeSetId, $attributeGroup, $attributeGroupSortOrder);
                    $this->logger->info('New Attribute group Created');

                    $groupData = $eavSetup->getAttributeGroupByCode($entityTypeId, $attributeSetId, $attributeGroupCode);
                    if (isset($groupData['attribute_group_id'])) {
                        $attributeGroupId = $groupData['attribute_group_id'];
                    }
                    
                    if ($attributeGroupCode == "general") {
                        if ($attributeGroupId > 0) {
                            $eavSetup->updateAttributeGroup($entityTypeId, $attributeSetId, $attributeGroupId, 'default_id', 0);
                        }

                        if ($defaultAttributeGroupId > 0) {
                            $eavSetup->updateAttributeGroup($entityTypeId, $attributeSetId, $defaultAttributeGroupId, 'default_id', 1);
                        }
                    }
                }
                $this->logger->info('Attribute Group Id = '.$attributeGroupId);

                $attributeSortOrder = 1;
                foreach ($arrAttributes as $attributeName => $attributeFilters) {
                    $attributeCode = $this->convertToAttributeCode($attributeName);
                    $attributeId = $eavSetup->getAttributeId($entityTypeId, $attributeCode);
                    $this->logger->info('Attribute Id = '.$attributeId);
                    /**
                    * Insert/Create a simple text attribute
                    */
                    if ($attributeId == 0) {
                        if ($attributeFilters["Filterable"] == "y") {
                            $attributeFilterable = true;
                            $attributeSearchable = true;
                            $attributeType = 'int';
                            $attributeInput = 'select';
                            $attributeSource = 'Magento\Eav\Model\Entity\Attribute\Source\Table';
                        } else {
                            $attributeFilterable = false;
                            $attributeSearchable = false;
                            $attributeType = 'text';
                            $attributeInput = 'text';
                            $attributeSource = '';
                        }

                        if ($attributeFilters["Comparable"] == "y") {
                            $attributeComparable = true;
                        } else {
                            $attributeComparable = false;
                        }

                        $eavSetup->addAttribute(
                            $entityTypeId,
                            $attributeCode,
                            [
                                'type' => $attributeType,
                                'backend' => '',
                                'frontend' => '',
                                'label' => $attributeName,
                                'input' => $attributeInput,
                                'class' => '',
                                'source' => $attributeSource,
                                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                                'visible' => true,
                                'required' => false,
                                'user_defined' => true,
                                'default' => '',
                                'searchable' => $attributeSearchable,
                                'filterable' => $attributeFilterable,
                                'comparable' => $attributeComparable,
                                'visible_on_front' => true,
                                'used_in_product_listing' => false,
                                'unique' => false,
                                'apply_to' => ''
                            ]
                        );

                        $this->logger->info('Attribute Created');
                        $attributeId = $eavSetup->getAttributeId($entityTypeId, $attributeCode);
                    }
                    $this->logger->info('Attribute Id = '.$attributeId);

                    /* Map attribute to attribute group */
                    if ($attributeId > 0 && $attributeGroupId > 0) {
                        $eavSetup->addAttributeToGroup(
                            $entityTypeId,
                            $attributeSetId,
                            $attributeGroupId,
                            $attributeCode,
                            $attributeSortOrder
                        );

                        $attributeSortOrder++;
                    }
                }

                $attributeGroupSortOrder++;
            }

            $attributeSetSortOrder++;
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
     * @param string $attributeName
     * @return string
     * @since 100.1.0
     */
    public function convertToAttributeCode($attributeName)
    {
        return trim(preg_replace('/[^a-z0-9]+/', '_', strtolower($attributeName)), '_');
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return ['Cybage\AttributeClustering\Setup\Patch\Data\AddProductAttributes'];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
