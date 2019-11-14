<?php
/**
 * BFL Cybage_Generic
 *
 * @category   Cybage_Generic Module
 * @package    BFL Cybage_Generic
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\Generic\Block;

class Footer extends \Magento\Framework\View\Element\Template {
    
    /**
     * @var \Magento\Framework\Registry 
     */
    protected $_registry;
    
    /**
     * Constructor
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context,
    \Magento\Framework\Registry $registry, array $data = []
    ) {
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getCurrentCategory() {
        return $this->_registry->registry('current_category');
    }

    public function getCurrentProduct() {
        return $this->_registry->registry('current_product');
    }
}
