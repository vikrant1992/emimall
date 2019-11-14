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

namespace Cybage\CatalogProduct\Model\Compare;

class Products
{
    /**
     * Showing only those products in search, on compare page whose visibility is set 
     * to show in "Catalog, Search"
     * 
     * 1 => Not Visible Individually
     * 2 => Catalog
     * 3 => Search
     * 4 => Catalog, Search
     */
    const VISIBILITY_VALUE = 4;
    
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
    }

    /**
     * getSimilarProducts
     * @param type $data
     * @return type
     */
    public function getSimilarProducts($data)
    {
        $products = $productData = [];
        if (isset($data) && !empty($data)) {
            $collection = $this->_productCollectionFactory->create()
                    ->addFieldToSelect("name")
                    ->addFieldToFilter('attribute_set_id', $data['attribute_set_id'])
                    ->addFieldToFilter('entity_id', ['nin' => $data['existing_products']])
                    ->addAttributeToFilter('visibility', self::VISIBILITY_VALUE);
            foreach ($collection as $item) {
                $products['value'] = $item->getEntityId();
                $products['label'] = $item->getName();
                $productData[] = $products;
            }
        }
        return $productData;
    }
}
