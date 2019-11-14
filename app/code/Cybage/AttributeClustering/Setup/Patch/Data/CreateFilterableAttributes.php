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

class CreateFilterableAttributes implements DataPatchInterface
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
        $this->arrMappedAttrCodes = array(
            'viewing_angle'=>'view_angle',
            'indoor_weight_kg'=>'indoor_weight',
            'outdoor_weight_kg'=>'outdoor_weight',
            'dedicated_graphics_memory_capacity' => 'dedicated_graphics_memory',
            'washing_capacity_kg'=>'washing_capacity',
            '3d'=>'desk_3d',
            'function_type'=>'function_type_wm'
        );

        $this->arrNewProductAttrs = [
            "Refrigerators"=>[
                "General"=>[
                    "Capacity"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Color"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Capacity Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Color Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Refrigerator Type"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Refrigerator Type Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Features"=>[
                    "Defrosting Type"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Defrosting Type Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Energy"=>[
                    "Energy Rating"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Energy Rating Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ]
            ],
            "AC"=>[
                "General"=>[
                    "Technology Used"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Technology Used Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "AC Type"=>["Filterable"=>"y","Comparable"=>"n"],
                    "AC Type Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Capacity"=>[
                    "Capacity in Tons"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Capacity in Tons Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Power"=>[
                    "Energy Rating"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Energy Rating Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Features"=>[
                    "Condenser Coil"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Condenser Coil Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ]
            ],
            "TV"=>[
                "General"=>[
                    "Color"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Color Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Display"=>[
                    "HD Type"=>["Filterable"=>"n","Comparable"=>"y"],
                    "HD Type Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Screen Size"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Screen Size Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Screen Type"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Screen Type Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Smart Tv"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Smart Tv Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Features"=>[
                    "Operating System"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Operating System Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                ]
            ],
            "Smartphones"=>[
                "General"=>[
                    "Color"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Color Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Battery"=>[
                    "Battery"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Battery Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Camera"=>[
                    "Primary Camera"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Primary Camera Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Secondary Camera"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Secondary Camera Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Memory"=>[
                    "RAM"=>["Filterable"=>"y","Comparable"=>"y"],
                    "RAM Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Internal Storage"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Internal Storage Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Display"=>[
                    "Screen Size"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Screen Size Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Processor & OS"=>[
                    "Processor Speed"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Processor Speed Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Operating System"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Operating System Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ]
            ],
            "Washing Machines"=>[
                "General"=>[
                    "Color"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Color Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Function type"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Function type Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Washing"=>[
                    "Washing Capacity (kg)"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Washing Capacity (kg) Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Services"=>[
                    "Power Consumption"=>["Filterable"=>"n","Comparable"=>"n"],
                    "Power Consumption Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                ]
            ],
            "Laptops"=>[
                "Display"=>[
                    "Screen Size"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Screen Size Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Memory"=>[
                    "RAM"=>["Filterable"=>"y","Comparable"=>"y"],
                    "RAM Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Hard Disk Capacity"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Hard Disk Capacity Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Processor"=>[
                    "Processor Brand"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Processor Brand Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Processor Count"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Processor Count Plp"=>["Filterable"=>"n","Comparable"=>"n"],
                    "Processor Speed"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Processor Speed Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "OS"=>[
                    "Operating System"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Operating System Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                ],
                "General"=>[
                    "Weight"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Weight Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                ]
            ],
            "Tablets"=>[
                "General"=>[
                    "Color"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Color Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                ],
                "Display"=>[
                    "Screen Size"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Screen Size Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Display Resolution"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Display Resolution Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "OS"=>[
                    "Operating System"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Operating System Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                ],
                "Camera"=>[
                    "Primary Camera"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Primary Camera Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "Secondary Camera"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Secondary Camera Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ],
                "Memory & Storage"=>[
                    "Internal Storage"=>["Filterable"=>"y","Comparable"=>"y"],
                    "Internal Storage Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                    "RAM"=>["Filterable"=>"y","Comparable"=>"y"],
                    "RAM Plp"=>["Filterable"=>"y","Comparable"=>"n"],
                ],
                "Battery"=>[
                    "Battery"=>["Filterable"=>"n","Comparable"=>"y"],
                    "Battery Plp"=>["Filterable"=>"y","Comparable"=>"n"]
                ]
            ]
        ];
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
                    
                    $generatedAttributeCode = $this->convertToAttributeCode($attributeName);

                    $attributeCode = isset($this->arrMappedAttrCodes[$generatedAttributeCode]) ? $this->arrMappedAttrCodes[$generatedAttributeCode] : $generatedAttributeCode;

                    $attributeId = $eavSetup->getAttributeId($entityTypeId, $attributeCode);
                    $this->logger->info('Attribute Id = '.$attributeId);

                    /**
                    * Insert/Create a simple text attribute
                    */
                    if ($attributeId == 0) {
                        $attributeVisibleOnFront = true;
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

                        if (strpos($attributeName, 'Plp') !== false) {
                            $attributeVisibleOnFront = false;
                            $attributeName = str_replace("Plp","",$attributeName);
                            $attributeSearchable = false;
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
                                'visible_on_front' => $attributeVisibleOnFront,
                                'used_in_product_listing' => false,
                                'unique' => false,
                                'apply_to' => ''
                            ]
                        );

                        $this->logger->info('Attribute Created');
                        $attributeId = $eavSetup->getAttributeId($entityTypeId, $attributeCode);
                    }else{
                        if (!(strpos($attributeCode, 'plp') !== false)) {
                            $eavSetup->updateAttribute(
                                $entityTypeId,
                                $attributeCode,
                                'is_filterable',
                                0
                            );
                        }
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
     * Update Existing Attribute
     * @param string $attributeCode
     */
    public function updateAttribute($attributeCode) {
        
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
