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

namespace Cybage\CatalogProduct\Model\ResourceModel\Product\Compare\Item;

class Collection extends \Magento\Catalog\Model\ResourceModel\Product\Compare\Item\Collection
{

    public function getComparableAttributes()
    {
        if ($this->_comparableAttributes === null) {
            $this->_comparableAttributes = [];
            $setIds = $this->_getAttributeSetIds();
            if ($setIds) {
                $attributeIds = $this->_getAttributeIdsBySetIds($setIds);

                $select = $this->getConnection()->select()->from(
                    ['main_table' => $this->getTable('eav_attribute')]
                )->join(
                    ['additional_table' => $this->getTable('catalog_eav_attribute')],
                    'additional_table.attribute_id=main_table.attribute_id'
                )->join(
                    ['eea' => $this->getTable('eav_entity_attribute')],
                    'eea.entity_type_id = main_table.entity_type_id AND eea.attribute_id = main_table.attribute_id',
                    []
                )->join(
                    ['eag' => $this->getTable('eav_attribute_group')],
                    'eag.attribute_group_id = eea.attribute_group_id',
                    ['eag.attribute_group_name']
                )->joinLeft(
                    ['al' => $this->getTable('eav_attribute_label')],
                    'al.attribute_id = main_table.attribute_id AND al.store_id = ' . (int) $this->getStoreId(),
                    [
                            'store_label' => $this->getConnection()->getCheckSql(
                                'al.value IS NULL',
                                'main_table.frontend_label',
                                'al.value'
                            )
                                ]
                )->where(
                    'additional_table.is_comparable=?',
                    1
                )->where(
                    'main_table.attribute_id IN(?)',
                    $attributeIds
                )
                        ->group('eag.attribute_group_name')
                        ->group('main_table.attribute_code');

                $attributesData = $this->getConnection()->fetchAll($select);
                if ($attributesData) {
                    $entityType = \Magento\Catalog\Model\Product::ENTITY;
                    $this->_eavConfig->importAttributesData($entityType, $attributesData);

                    foreach ($attributesData as $data) {
                        $attribute = $this->_eavConfig->getAttribute($entityType, $data['attribute_code']);
                        $this->_comparableAttributes[$attribute->getAttributeCode()] = $attribute;
                    }
                    unset($attributesData);
                }
            }
        }
        return $this->_comparableAttributes;
    }
}
