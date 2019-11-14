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

namespace Cybage\CustomEav\Block\Adminhtml\Product\Attribute\Set;

/**
 * Class Edit
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{

    /**
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Initialize Import Edit Block.
     */
    protected function _construct() 
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Cybage_CustomEav';
        $this->_controller = 'adminhtml_product_attribute_set';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save'));
        $this->buttonList->remove('delete');
    }

    /**
     * Retrieve text for header element depending on loaded image.
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText() {
        return __('Add Row Data');
    }

    /**
     * Get form action URL.
     *
     * @return string
     */
    public function getFormActionUrl() {
        if ($this->hasFormActionUrl()) {
            return $this->getData('form_action_url');
        }
        return $this->getUrl('*/*/save');
    }
}
