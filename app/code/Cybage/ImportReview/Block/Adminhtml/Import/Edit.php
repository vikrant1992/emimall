<?php

/**
 * BFL Cybage_ImportReview
 *
 * @category   Cybage_ImportReview
 * @package    BFL Cybage_ImportReview
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\ImportReview\Block\Adminhtml\Import;

/**
 * Class Edit
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{

    /**
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
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
    protected function _construct() {

        $this->_objectId = 'id';
        $this->_blockGroup = 'Cybage_ImportReview';
        $this->_controller = 'adminhtml_import';
        parent::_construct();
        $this->buttonList->remove('back');
        $this->buttonList->update('save', 'label', __('Submit'));
        $this->buttonList->remove('reset');
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
