<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cybage\BreadcrumbCustomization\Block;

use Magento\Catalog\Helper\Data;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\Store;
use Magento\Framework\Registry;

class Customcrumbs extends \Magento\Framework\View\Element\Template
{

    /**
     *
     * @var Data
     */
    protected $_catalogData = null;

    /**
     * @param Context $context
     * @param Data $catalogData
     * @param Data $registry
     * @param array $data
     */
    public function __construct(
		Context $context, 
		Data $catalogData, 
		Registry $registry,
		array $data = [])
    {
        $this->_catalogData = $catalogData;	
		$this->registry = $registry;
        parent::__construct($context, $data);
    }
    
    /*
     * Cybage\BreadcrumbCustomization\Block\Customcrumbs getCrumbs
     * function for getting all breadcrumbs
     */
    public function getCrumbs() {
        $customcrumbs = array();

        $customcrumbs[] = array(
            'label' => __('Home'),
            'title' => __('Go to Home Page'),
            'link' => $this->_storeManager->getStore()->getBaseUrl()
        );

        $path = $this->_catalogData->getBreadcrumbPath();
        $product = $this->registry->registry('current_product');
        $categoryCollection = clone $product->getCategoryCollection();
        $categoryCollection->clear();
        $categoryCollection->addAttributeToSort('level', $categoryCollection::SORT_ORDER_DESC)->addAttributeToFilter('path', array('like' => "1/" . $this->_storeManager->getStore()->getRootCategoryId() . "/%"));
        $categoryCollection->setPageSize(1);
        $breadcrumbCategories = $categoryCollection->getFirstItem()->getParentCategories();
        foreach ($breadcrumbCategories as $category) {
            $customcrumbs[] = array(
                'label' => __($category->getName()),
                'title' => __($category->getName()),
                'link' => __($category->getUrl())
            );
        }
        $customcrumbs[] = array(
            'label' => __($product->getName()),
            'title' => __($product->getName()),
            'link' => ''
        );

        return $customcrumbs;
    }

}