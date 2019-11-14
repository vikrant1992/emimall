<?php

/**
 * BFL Storelocator
 *
 * @category   Storelocator Module
 * @package    BFL Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Model\Dropdown;

class Subcategory extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * Constructor
     *
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    ) {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * getAllSubcategories
     *
     * @return array
     */
    public function getAllOptions()
    {
        $categoryCollection = $this->_categoryCollectionFactory->create()
                ->addAttributeToSelect(['*'])
                ->addAttributeToFilter('is_active', '1');
        $options = [];
        foreach ($categoryCollection as $category) {
            if (!empty($category->getBflId())) {
                $options[] = [
                    'label' => $category->getName(),
                    'value' => $category->getBflId()
                ];
            }
        }
        return $options;
    }
}
