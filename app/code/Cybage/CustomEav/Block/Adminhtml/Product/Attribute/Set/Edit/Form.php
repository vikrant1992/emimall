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

namespace Cybage\CustomEav\Block\Adminhtml\Product\Attribute\Set\Edit;

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
     * @param \Magento\Eav\Model\Entity\Attribute\SetFactory $setFactory
     * @param \Magento\Catalog\Api\ProductAttributeManagementInterface $productAttributeManagementInterface
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Eav\Model\Entity\Attribute\SetFactory $setFactory,
        \Magento\Catalog\Api\ProductAttributeManagementInterface $productAttributeManagementInterface,
        array $data = array()
    ) {
        $this->_setFactory = $setFactory;
        $this->_productAttributeManagementInterface = $productAttributeManagementInterface;
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
        $data = $this->_setFactory->create()->load($this->getRequest()->getParam('id'));
        $attributeOptions = $this->getAttributesArray($this->getRequest()->getParam('id'));
        
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
        
       $fieldset = $form->addFieldset('set_name', ['legend' => __('Edit Attribute Set Mapping')]);
        $fieldset->addField(
            'attribute_set_id',
            'hidden',
            [
                'value' => $data->getAttributeSetId(),
                'name' => 'attribute_set_id',
            ]
        );
        $fieldset->addField(
            'attribute_set_name',
            'text',
            [
                'label' => __('Name'),
                'note' => __('For internal use'),
                'name' => 'attribute_set_name',
                'required' => true,
                'disabled' => true,
                'class' => 'required-entry validate-no-html-tags',
                'value' => $data->getAttributeSetName()
            ]
        );
        $fieldset->addField(
            'attribute_set_lob',
            'text',
            [
                'label' => __('LOB'),
                'name' => 'attribute_set_lob',
                'required' => true,
                'class' => 'required-entry validate-no-html-tags',
                'value' => $data->getAttributeSetLob()
            ]
        );
        $fieldset->addField(
            'attribute_set_keyhighlights',
            'multiselect',
            [
                'values'     => $attributeOptions,
                'value' => explode(",", $data->getAttributeSetKeyhighlights()),
                'name' => 'attribute_set_keyhighlights[]',
                'label' => __('Keyhighlights'),
                'title' => __('Keyhighlights Attributes'),
                'class' => 'required-entry'
            ]
        );
        if (!$this->getRequest()->getParam('id', false)) {
            $fieldset->addField('gotoEdit', 'hidden', ['name' => 'gotoEdit', 'value' => '1']);

            $sets = $this->_setFactory->create()->getResourceCollection()->setEntityTypeFilter(
                $this->_coreRegistry->registry('entityType')
            )->load()->toOptionArray();

            $fieldset->addField(
                'skeleton_set',
                'select',
                [
                    'label' => __('Based On'),
                    'name' => 'skeleton_set',
                    'required' => true,
                    'class' => 'required-entry',
                    'values' => $sets
                ]
            );
        }
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * 
     * @param type $attributeSetId
     * @return type
     */
    public function getAttributesArray($attributeSetId)
    {
        $data = [];
        $attributes = $this->getAttributesByAttributeSet($attributeSetId);
        if ($attributes) {
            foreach ($attributes as $attribute) {
                $data[] = [
                    'value'=> $attribute->getAttributeId(),
                    'label' => $attribute->getAttributeCode()
                    ];
            }
        }
        return $data;
    }

    /**
     * getAttributesByAttributeSet
     * @param type $attributeSetId
     * @return type
     */
    public function getAttributesByAttributeSet($attributeSetId)
    {
        $productAttributes = '';
        if (isset($attributeSetId)) {
            $productAttributes = $this->_productAttributeManagementInterface->getAttributes($attributeSetId);
        }
        return $productAttributes;
    }
}
