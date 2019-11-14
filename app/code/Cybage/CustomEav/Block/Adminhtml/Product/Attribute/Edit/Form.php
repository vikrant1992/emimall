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

namespace Cybage\CustomEav\Block\Adminhtml\Product\Attribute\Edit;

class Form extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Edit\Form
{
    /**
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var DataForm $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype' => 'multipart/form-data']]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return $this;
    }
}
