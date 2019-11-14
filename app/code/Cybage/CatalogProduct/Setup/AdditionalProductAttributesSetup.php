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

class AdditionalProductAttributesSetup extends EavSetup
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
                    'is_easy_emi' => [
                        'type' => 'int',
                        'label' => 'Easy EMI',
                        'input' => 'select',
                        'source' => Boolean::class,
                        'default' => '1',
                        'required' => false,
                        'sort_order' => 40,
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
