<?php

/**
 * BFL Cybage_Storelocator
 *
 * @category   Cybage_Storelocator
 * @package    BFL Cybage_Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Block\Adminhtml\Import\Edit;

/**
 * Class Form
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * Constructor
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
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Add fieldsets
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
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
            'import_dealer_file',
            'file',
            [
            'name' => 'import_dealer_file',
            'label' => __('Upload Dealer CSV File'),
            'title' => __('Upload Dealer CSV File'),
            'class' => 'input-file',
                ]
        );

        $fieldset->addField(
            'import_city_file',
            'file',
            [
            'name' => 'import_city_file',
            'label' => __('Upload City CSV File'),
            'title' => __('Upload City CSV File'),
            'class' => 'input-file',
                ]
        );

        $fieldset->addField(
            'import_group_file',
            'file',
            [
            'name' => 'import_group_file',
            'label' => __('Upload Dealer Group CSV File'),
            'title' => __('Upload Dealer Group CSV File'),
            'class' => 'input-file',
                ]
        );

        $fieldset->addField(
            'import_oem_file',
            'file',
            [
            'name' => 'import_oem_file',
            'label' => __('Upload OEM CSV File'),
            'title' => __('Upload OEM CSV File'),
            'class' => 'input-file',
                ]
        );

        $fieldset->addField(
            'import_offer_file',
            'file',
            [
            'name' => 'import_offer_file',
            'label' => __('Upload Offers CSV File'),
            'title' => __('Upload Offers CSV File'),
            'class' => 'input-file',
                ]
        );

        $fieldset->addField(
            'import_offertype_file',
            'file',
            [
            'name' => 'import_offertype_file',
            'label' => __('Upload Offers type CSV File'),
            'title' => __('Upload Offers type CSV File'),
            'class' => 'input-file',
                ]
        );
        
        $fieldset->addField(
            'import_dealer_flag_file',
            'file',
            [
            'name' => 'import_dealer_flag_file',
            'label' => __('Upload dealer flag CSV File'),
            'title' => __('Upload dealer flag CSV File'),
            'class' => 'input-file',
            'after_element_html' => 'NOTE: Comma separeted dealer ids in 1 row of csv. eg. (411024,411044,411373,411039,411029)'
                ]
        );
        return parent::_prepareForm();
    }
}
