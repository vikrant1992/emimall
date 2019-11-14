<?php

namespace Cybage\Storelocator\Controller\Index;

use Cybage\Storelocator\Block\Index\Index as StoresBlock;
use Magento\Framework\Controller\Result\JsonFactory as ResultJsonFactory;

class Stores extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $storesBlock;
    protected $resultJsonFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param StoresBlock $storeBlock
     * @param ResultJsonFactory $resultJsonFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        StoresBlock $storeBlock,
        ResultJsonFactory $resultJsonFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->storesBlock = $storeBlock;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $stores = $this->storesBlock->getStoreList();
        return $this->resultJsonFactory->create()->setData($stores);
    }
}
