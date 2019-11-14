<?php
/**
 * BFL Cybage_CustomEav
 *
 * @category   Cybage_CustomEav
 * @package    BFL Cybage_CustomEav
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\CustomEav\Plugin\Block\Adminhtml\Product\Attribute\Edit\Tab;

class Front
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager 
     */
    protected $_storeManager;

    /**
     * 
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_coreRegistry = $registry;
    }
    
    /**
     * Get form HTML
     *
     * @return string
     */
    public function aroundGetFormHtml(
        \Magento\Catalog\Block\Adminhtml\Product\Attribute\Edit\Tab\Front $subject,
        \Closure $proceed
    )
    {
        $attributeObject = $this->_coreRegistry->registry('entity_attribute');
        $highlight = $attributeObject->getData('highlight_icon');
        $highlightURL = "";
        
        if($highlight!=""){
            $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $highlightURL = $mediaUrl.'highlight_icon'.$highlight;
        }
        
        $form = $subject->getForm();
        $fieldset = $form->getElement('front_fieldset');
        $fieldset->addType('required_image', 'Cybage\CustomEav\Block\Adminhtml\Helper\Image\Required');
        $fieldset->addField(
            'highlight_icon',
            'required_image',
            [
                'name' => 'highlight_icon',
                'label' => __('Attribute Highlight Icon'),
                'title' => __('Attribute Highlight Icon'),
                'value' => $highlightURL,
                'note' => 'Allow image type: jpg, jpeg, gif, png, svg'
            ]
        );
        return $proceed();
    }
}