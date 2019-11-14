<?php

/**
 * BFL Cybage_Productdetail
 *
 * @category   Cybage_Productdetail Block
 * @package    BFL Cybage_Productdetail
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
 
namespace Cybage\Productdetail\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Model\ResourceModel\Product;

/**
 * Class ProductSetup
 */
class ProductSetup extends EavSetup
{

    public function getDefaultEntities()
    {
        return [
            'catalog_product' => [
                'entity_type_id' => CategorySetup::CATALOG_PRODUCT_ENTITY_TYPE_ID,
                'entity_model' => Product::class,
                'attribute_model' => Attribute::class,
                'table' => 'catalog_product_entity',
                'additional_attribute_table' => 'catalog_eav_attribute',
                'entity_attribute_collection' =>
                Collection::class,
                'attributes' => [
                    'deliveryandreturn' => [
                            'type' => 'text',
                            'label' => 'Delivery and return',
                            'input' => 'textarea',
                            'source' => '',
                            'frontend' => '',
                            'required' => false,
                            'note' => '',
                            'class' => '',
                            'backend' => '',
                            'sort_order' => '30',
                            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                            'default' => null,
                            'visible' => true,
                            'user_defined' => true,
                            'searchable' => false,
                            'filterable' => false,
                            'comparable' => false,
                            'visible_on_front' => true,
                            'unique' => false,
                            'apply_to' => '',
                            'group' => 'product-details',
                            'used_in_product_listing' => false,
                            'is_used_in_grid' => true,
                            'is_visible_in_grid' => false,
                            'is_filterable_in_grid' => false,
                            'option' => ['values' => [""]]
                    ],
                ]
            ]
        ];
    }
}
