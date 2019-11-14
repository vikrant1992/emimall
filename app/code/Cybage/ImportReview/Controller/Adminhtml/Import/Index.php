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

namespace Cybage\ImportReview\Controller\Adminhtml\Import;

class Index extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Cybage_ImportReview::import_customer_review_product';

    protected $resultPageFactory;
    
    /**
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute() {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE);
        $resultPage->getConfig()->getTitle()->prepend(__('Import Customer Review'));
        return $resultPage;
    }
}
