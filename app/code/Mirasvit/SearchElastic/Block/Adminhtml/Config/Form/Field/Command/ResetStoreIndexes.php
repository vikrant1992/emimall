<?php
namespace Mirasvit\SearchElastic\Block\Adminhtml\Config\Form\Field\Command;

use Mirasvit\SearchElastic\Block\Adminhtml\Config\Form\Field\Command;

class ResetStoreIndexes extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getAction()
    {
        return 'resetStoreIndexes';
    }
}
