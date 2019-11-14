<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cybage\Generic\Model\Import\Product;

use Magento\CatalogImportExport\Model\Import\Product;
use Cybage\Generic\Helper\Import;
use \Magento\CatalogImportExport\Model\Import\Product\RowValidatorInterface;
/**
 * Class Validator
 *
 * @api
 * @since 100.0.2
 */
class Validator extends \Magento\CatalogImportExport\Model\Import\Product\Validator implements \Magento\CatalogImportExport\Model\Import\Product\RowValidatorInterface
{
    
    /**
     *
     * @var \Cybage\Generic\Helper\Import
     */
    protected $importHelper;
    
    /**
     * @var \Magento\Framework\Stdlib\StringUtils
     */
    protected $string;
    
    /**
     * @var RowValidatorInterface[]|AbstractValidator[]
     */
    protected $validators = [];
    
    /**
     * @var \Magento\Eav\Model\AttributeRepository
     */
    protected $_attributeRepository;
    
    /**
     * @var \Magento\Eav\Api\AttributeOptionManagementInterface 
     */
    protected $_attributeOptionManagement;
    
    /**
     * @var \Magento\Eav\Model\Entity\Attribute\Option 
     */
    protected $_option;
    
    /**
     * @var \Magento\Eav\Api\Data\AttributeOptionLabelInterface 
     */
    protected $_attributeOptionLabel;
    
    /**
     * @var \Magento\Catalog\Model\Product\Attribute\OptionManagement 
     */
    protected $prodOptionManagement;
    
    /**
     * @param Import $importHelper
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Eav\Model\AttributeRepository $attributeRepository
     * @param \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement
     * @param \Magento\Eav\Api\Data\AttributeOptionLabelInterface $attributeOptionLabel
     * @param \Magento\Eav\Model\Entity\Attribute\Option $option
     * @param \Magento\Catalog\Model\Product\Attribute\OptionManagement $prodOptionManagement
     * @param array $validators
     */
    public function __construct(
        \Cybage\Generic\Helper\Import $importHelper,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Eav\Model\AttributeRepository $attributeRepository,
        \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement,
        \Magento\Eav\Api\Data\AttributeOptionLabelInterface $attributeOptionLabel,
        \Magento\Eav\Model\Entity\Attribute\Option $option,
        \Magento\Catalog\Model\Product\Attribute\OptionManagement $prodOptionManagement,
        $validators = []
    ) {
        $this->importHelper = $importHelper;
        $this->string = $string;
        $this->_attributeRepository = $attributeRepository;
        $this->_attributeOptionManagement = $attributeOptionManagement;
        $this->_option = $option;
        $this->_attributeOptionLabel = $attributeOptionLabel;
        $this->validators = $validators;
        $this->prodOptionManagement = $prodOptionManagement;
        parent::__construct($string,$validators);
    }
    
    /**
     * Validate Drop down Option
     * @param string $attrCode
     * @param string $label
     * @param array $possibleOptions
     * @return boolean
     */
    public function validateDropdownOption($attrCode, $label, $possibleOptions)
    {
        if (!isset($possibleOptions[strtolower($label)])) {
            $optionId = $this->importHelper->createOrGetId($attrCode, $label);
            if (!isset($this->_rowData['product_type'])) {
                return false;
            }
            if($optionId){
                $entityTypeModel = $this->context->retrieveProductTypeByName($this->_rowData['product_type']);
                $label = strtolower($label);
                $entityTypeModel->addAttributeOption($attrCode, $label, $optionId);
                return true;
            }
            return false;
        }
        return true;
    }
    
    /**
     * Is attribute valid
     *
     * @param string $attrCode
     * @param array $attrParams
     * @param array $rowData
     * @return bool
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function isAttributeValid($attrCode, array $attrParams, array $rowData)
    {
        $this->_rowData = $rowData;
        if (isset($rowData['product_type']) && !empty($attrParams['apply_to'])
            && !in_array($rowData['product_type'], $attrParams['apply_to'])
        ) {
            return true;
        }
        if (!$this->isRequiredAttributeValid($attrCode, $attrParams, $rowData)) {
            $valid = false;
            $this->_addMessages(
                [
                    sprintf(
                        $this->context->retrieveMessageTemplate(
                            RowValidatorInterface::ERROR_VALUE_IS_REQUIRED
                        ),
                        $attrCode
                    )
                ]
            );
            return $valid;
        }

        if (!strlen(trim($rowData[$attrCode]))) {
            return true;
        }

        if ($rowData[$attrCode] === $this->context->getEmptyAttributeValueConstant() && !$attrParams['is_required']) {
            return true;
        }

        switch ($attrParams['type']) {
            case 'varchar':
            case 'text':
                $valid = $this->textValidation($attrCode, $attrParams['type']);
                break;
            case 'decimal':
            case 'int':
                $valid = $this->numericValidation($attrCode, $attrParams['type']);
                break;
            case 'select':
                $valid = $this->validateDropdownOption($attrCode, $rowData[$attrCode], $attrParams['options']);
                break;
            case 'boolean':
                $valid = $this->validateOption($attrCode, $attrParams['options'], $rowData[$attrCode]);
                break;
            case 'multiselect':
                $values = $this->context->parseMultiselectValues($rowData[$attrCode]);
                foreach ($values as $value) {
                    $valid = $this->validateOption($attrCode, $attrParams['options'], $value);
                    if (!$valid) {
                        break;
                    }
                }
                $uniqueValues = array_unique($values);
                if (count($uniqueValues) != count($values)) {
                    $valid = false;
                    $this->_addMessages([RowValidatorInterface::ERROR_DUPLICATE_MULTISELECT_VALUES]);
                }
                break;
            case 'datetime':
                $val = trim($rowData[$attrCode]);
                $valid = strtotime($val) !== false;
                if (!$valid) {
                    $this->_addMessages([RowValidatorInterface::ERROR_INVALID_ATTRIBUTE_TYPE]);
                }
                break;
            default:
                $valid = true;
                break;
        }
        if ($valid && !empty($attrParams['is_unique'])) {
            if (isset($this->_uniqueAttributes[$attrCode][$rowData[$attrCode]])
                && ($this->_uniqueAttributes[$attrCode][$rowData[$attrCode]] != $rowData[Product::COL_SKU])) {
                $this->_addMessages([RowValidatorInterface::ERROR_DUPLICATE_UNIQUE_ATTRIBUTE]);
                return false;
            }
            $this->_uniqueAttributes[$attrCode][$rowData[$attrCode]] = $rowData[Product::COL_SKU];
        }
        if (!$valid) {
            $this->setInvalidAttribute($attrCode);
        }
        return (bool)$valid;
    }
    
    /**
     * Check if value is valid attribute option
     *
     * @param string $attrCode
     * @param array $possibleOptions
     * @param string $value
     * @return bool
     */
    private function validateOption($attrCode, $possibleOptions, $value)
    {
        if (!isset($possibleOptions[strtolower($value)])) {
            $this->_addMessages(
                [
                    sprintf(
                        $this->context->retrieveMessageTemplate(
                            RowValidatorInterface::ERROR_INVALID_ATTRIBUTE_OPTION
                        ),
                        $attrCode
                    )
                ]
            );
            return false;
        }
        return true;
    }
}
