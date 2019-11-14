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

class Citylist extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Cybage\Storelocator\Model\DealergroupFactory $cityFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Cybage\Storelocator\Model\CityFactory $cityFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->cityFactory = $cityFactory;
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
        $cityCollection = $this->cityFactory->create()
                ->getCollection()
                ->addFieldToFilter('city_name', ['like' => $value . '%'])
                ->getData();
        $result = [];
        foreach ($cityCollection as $city) {
            $result[] = $city['city_name'] . ' - ' . $city['bajaj_city_id'];
        }
        echo json_encode($result);
    }
}
