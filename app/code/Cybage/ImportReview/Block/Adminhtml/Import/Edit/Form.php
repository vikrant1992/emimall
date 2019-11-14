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

namespace Cybage\ImportReview\Block\Adminhtml\Import\Edit;

/**
 * Class Form
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * 
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param Options $locationOptions
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory, 
        array $data = array()
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Add fieldsets
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm() {      
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => [
                    'id' => 'edit_form',
                    'enctype' => 'multipart/form-data',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'base_fieldset',
            []
        );
        
        $fieldset->addField(
            'import_file', 'file',
            [
            'name' => 'import_file',
            'label' => __('Upload CSV File'),
            'title' => __('Upload CSV File'),
            'class' => 'input-file',
            'required' => true,
            ]
        );

        $fieldset->addField(
            'link', 'link',
            [
            'name' => 'link name',
            'href' => $this->getUrl('*/*/samplecsv'),
            'value' => 'Download Sample CSV',
            'label' => __(''),
            'title' => __(''),                
            'note' => 'NOTE : status column accepts value as 1 for Approved and 2 for Pending review'
            ]
        );
        return parent::_prepareForm();
    }
}
