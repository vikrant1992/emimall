<?php
/**
 * BFL Cybage_Storelocator
 *
 * @category   BFL Cybage_Storelocator Module
 * @package    BFL Cybage_Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
  namespace Cybage\Storelocator\Controller\Index;
  
    class Viewmore extends \Magento\Framework\App\Action\Action
    {
        /**
         * @var $_resultPageFactory
        */
        protected $_resultPageFactory;
        
        /**
        * Constructor
        *
        * @param \Magento\Framework\App\Action\Context $context
        * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
        */
        public function __construct(
            \Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
        ) {
             $this->_resultPageFactory = $resultPageFactory;
             parent::__construct($context);
        }
        
        /**
        * Execute view action
        *
        * @return \Magento\Framework\Controller\ResultInterface
        */
        public function execute()
        {
            $resultPage = $this->_resultPageFactory->create();
            $block=$resultPage->getLayout()->getBlock('view_more');
            $this->getResponse()->setBody($block->toHtml());
        }
    }