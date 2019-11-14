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
namespace Cybage\CatalogProduct\Block\Product;

class Customnav extends \Magento\Framework\View\Element\Template
{
/**
 * @param \Magento\Framework\View\Element\Template\Context $context
 * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
 * @param \Magento\Framework\Registry $registry
 * @param \Magento\Catalog\Helper\Category $categoryHelper
 * @param array $data
 */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_catalogLayer = $layerResolver->get();
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return string
     */
    public function getCatalogLeftNavHtml()
    {
        return $this->getChildHtml('catalog.leftnav');
    }
}
