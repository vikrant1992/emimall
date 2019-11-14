<?php

/**
 * BFL Storelocator
 *
 * @category   Storelocator Module
 * @package    BFL Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Controller\Adminhtml\Dealer;

class Grouplist extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Cybage\Storelocator\Model\DealergroupFactory $groupFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Cybage\Storelocator\Model\DealergroupFactory $groupFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->groupFactory = $groupFactory;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $value = $this->getRequest()->getParam('q');
        $groupModel = $this->groupFactory->create()
                ->getCollection()
                ->addFieldToFilter('store_name', ['like' => $value . '%'])
                ->getData();
        $result = [];
        foreach ($groupModel as $group) {
            $result[] = $group['store_name'] . ' - ' . $group['group_id'];
        }
        echo json_encode($result);
    }
}
