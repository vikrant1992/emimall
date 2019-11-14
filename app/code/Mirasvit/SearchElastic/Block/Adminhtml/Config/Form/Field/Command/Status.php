<?php
namespace Mirasvit\SearchElastic\Block\Adminhtml\Config\Form\Field\Command;

use Mirasvit\SearchElastic\Block\Adminhtml\Config\Form\Field\Command;

class Status extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getAction()
    {
        return 'status';
    }
}
