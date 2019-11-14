<?php
namespace Mirasvit\SearchElastic\Block\Adminhtml\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

abstract class Command extends Field
{
    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('Mirasvit_Search::config/form/field/command.phtml');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();

        return parent::render($element);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $buttonLabel = $originalData['button_label'];
        $this->addData([
            'button_label' => __($buttonLabel),
            'html_id'      => $element->getHtmlId(),
            'ajax_url'     => $this->_urlBuilder->getUrl('searchelastic/command/' . $this->getAction()),
        ]);

        return $this->_toHtml();
    }

    /**
     * {@inheritdoc}
     */
    abstract protected function getAction();
}
