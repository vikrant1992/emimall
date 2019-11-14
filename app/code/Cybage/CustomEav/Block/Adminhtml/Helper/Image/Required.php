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
namespace Cybage\CustomEav\Block\Adminhtml\Helper\Image;

class Required extends \Magento\Framework\Data\Form\Element\Image
{
    protected function _getDeleteCheckbox()
    {
        return '';
    }
}