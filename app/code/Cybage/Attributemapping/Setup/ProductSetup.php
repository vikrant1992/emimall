<?php

/**
 * BFL Attributemapping
 *
 * @category   Attributemapping Module
 * @package    BFL Attributemapping
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Attributemapping\Setup;

use Magento\Catalog\Setup\CategorySetup;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Model\ResourceModel\Product;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection;

class ProductSetup extends EavSetup {

    public function getDefaultEntities() {
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
                    'model_code' => [
                        'type' => 'varchar',
                        'label' => 'Model Code',
                        'input' => 'text',
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
                        'visible_on_front' => false,
                        'unique' => false,
                        'apply_to' => '',
                        'group' => 'product-details',
                        'used_in_product_listing' => false,
                        'is_used_in_grid' => true,
                        'is_visible_in_grid' => false,
                        'is_filterable_in_grid' => false,
                        'option' => array('values' => array(""))
                    ],
                    'model_name' => [
                        'type' => 'varchar',
                        'label' => 'Model Name',
                        'input' => 'text',
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
                        'visible_on_front' => false,
                        'unique' => false,
                        'apply_to' => '',
                        'group' => 'product-details',
                        'used_in_product_listing' => false,
                        'is_used_in_grid' => true,
                        'is_visible_in_grid' => false,
                        'is_filterable_in_grid' => false,
                        'option' => array('values' => array(""))
                    ],
                    'short_descriptor_title' => [
                        'type' => 'varchar',
                        'label' => 'Short descriptor title',
                        'input' => 'text',
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
                        'visible_on_front' => false,
                        'unique' => false,
                        'apply_to' => '',
                        'group' => 'product-details',
                        'used_in_product_listing' => false,
                        'is_used_in_grid' => true,
                        'is_visible_in_grid' => false,
                        'is_filterable_in_grid' => false,
                        'option' => array('values' => array(""))
                    ],
                    'short_descriptor' => [
                        'type' => 'text',
                        'label' => 'Short descriptor',
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
                        'visible_on_front' => false,
                        'unique' => false,
                        'apply_to' => '',
                        'group' => 'product-details',
                        'used_in_product_listing' => false,
                        'is_used_in_grid' => true,
                        'is_visible_in_grid' => false,
                        'is_filterable_in_grid' => false,
                        'wysiwyg_enabled' => true,
                        'is_html_allowed_on_front' => true,
                        'option' => array('values' => array(""))
                    ],
                    'footer_content' => [
                        'type' => 'text',
                        'label' => 'Footer Content',
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
                        'visible_on_front' => false,
                        'unique' => false,
                        'apply_to' => '',
                        'group' => 'product-details',
                        'used_in_product_listing' => false,
                        'is_used_in_grid' => true,
                        'is_visible_in_grid' => false,
                        'is_filterable_in_grid' => false,
                        'wysiwyg_enabled' => true,
                        'is_html_allowed_on_front' => true,
                        'option' => array('values' => array(""))
                    ],
                    'faq' => [
                        'type' => 'text',
                        'label' => 'Faq',
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
                        'visible_on_front' => false,
                        'unique' => false,
                        'apply_to' => '',
                        'group' => 'product-details',
                        'used_in_product_listing' => false,
                        'is_used_in_grid' => true,
                        'is_visible_in_grid' => false,
                        'is_filterable_in_grid' => false,
                        'wysiwyg_enabled' => true,
                        'is_html_allowed_on_front' => true,
                        'option' => array('values' => array(""))
                    ],
                ]
            ]
        ];
    }

}
