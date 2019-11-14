<?php

/**
 * BFL CatalogProduct
 *
 * @category   CatalogProduct Module
 * @package    BFL CatalogProduct
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\CatalogProduct\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Model\ResourceModel\Product;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;

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
                    'emi_starting_at' => [
                        'type' => 'decimal',
                        'label' => 'EMI starting at',
                        'input' => 'price',
                        'source' => '',
                        'frontend' => '',
                        'required' => false,
                        'note' => '',
                        'class' => '',
                        'backend' => 'Magento\Catalog\Model\Product\Attribute\Backend\Price',
                        'sort_order' => '30',
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'default' => null,
                        'visible' => true,
                        'user_defined' => true,
                        'searchable' => true,
                        'filterable' => true,
                        'comparable' => false,
                        'visible_on_front' => true,
                        'unique' => false,
                        'apply_to' => '',
                        'group' => 'product-details',
                        'used_in_product_listing' => true,
                        'used_for_sort_by' => 1,
                        'is_used_in_grid' => true,
                        'is_visible_in_grid' => true,
                        'is_filterable_in_grid' => true,
                        'option' => ''
                    ],
                    'spec_score' => [
                        'type' => 'decimal',
                        'label' => '91 mobiles Spec Score',
                        'input' => 'text',
                        'source' => '',
                        'frontend' => '',
                        'required' => false,
                        'note' => '',
                        'class' => '',
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
                        'used_in_product_listing' => true,
                        'used_for_sort_by' => 0,
                        'is_used_in_grid' => false,
                        'is_visible_in_grid' => false,
                        'is_filterable_in_grid' => false,
                        'option' => ''
                    ],
                    'zero_downpayment' => [
                        'type' => 'int',
                        'label' => 'zero Down Payment',
                        'input' => 'select',
                        'source' => Boolean::class,
                        'default' => '1',
                        'required' => false,
                        'sort_order' => 40,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'visible' => true,
                        'used_in_product_listing' => true,
                        'group' => 'product-details',
                    ],
                    'no_cost_emi' => [
                        'type' => 'int',
                        'label' => 'No cost EMI',
                        'input' => 'select',
                        'source' => Boolean::class,
                        'default' => '1',
                        'required' => false,
                        'sort_order' => 50,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'visible' => true,
                        'used_in_product_listing' => true,
                        'group' => 'product-details',
                    ]
                ]
            ]
        ];
    }
}
