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

use Cybage\Storelocator\Block\Index\Index as StoresBlock;
use Magento\Framework\Controller\Result\JsonFactory as ResultJsonFactory;
use Magento\Customer\Helper\Session\CurrentCustomer;

class Sfdc extends \Magento\Framework\App\Action\Action
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
     * @param \Cybage\Storelocator\Model\DealerFactory $dealerFactory
     * @param \Cybage\Storelocator\Model\CityFactory $cityFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param CurrentCustomer $currentCustomer
     * @param \Cybage\Storelocator\Helper\Sfdcapi $sfdc
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        StoresBlock $storeBlock,
        ResultJsonFactory $resultJsonFactory,
        \Cybage\Storelocator\Model\DealerFactory $dealerFactory,
        \Cybage\Storelocator\Model\CityFactory $cityFactory,
        \Magento\Customer\Model\Session $customerSession,
        CurrentCustomer $currentCustomer,
        \Cybage\Storelocator\Helper\Sfdcapi $sfdc,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->storesBlock = $storeBlock;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->dealerFactory = $dealerFactory;
        $this->cityFactory = $cityFactory;
        $this->customerSession = $customerSession;
        $this->currentCustomer = $currentCustomer;
        $this->sfdc = $sfdc;
        $this->cookieManager = $cookieManager;
        parent::__construct($context);
    }

    /**
     * Execute view action
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $dealerCollection = $this->dealerFactory->create()
                ->getCollection()
                ->addFieldToFilter('dealer_id', ['eq' => $data['storeid']])
                ->getFirstItem()
                ->getData();
        $customer = $this->currentCustomer->getCustomer();
        $firstname = $customer->getFirstname();
        $gaString = $this->cookieManager->getCookie(
            '_ga'
        );
        $gaValue = ltrim(strstr($gaString, '.'), '.');
        $gaTrimValue = ltrim(strstr($gaValue, '.'), '.');
        $requestData = [
            "custType" => $this->customerSession->getBflCustomerFlag(),
            "customerMobileNumber" => $firstname,
            "customerName" => $this->customerSession->getBflCustomerName(),
            "dealerCity" => $this->getCityId($dealerCollection['city_id']),
            "dealerMobileNumber" => $dealerCollection['phone'],
            "dealerName" => $dealerCollection['hexacode'],
            "finnOneModelCode" => $this->customerSession->getBflModelCode(),
            "schemeCode" => '',
            "sourceUniqueID" => $gaTrimValue,
            "maximumTenure" => "",
            "modelName" => $this->customerSession->getBflModelName(),
            "source" => "MKT",
            "channel" => "EMI MALL"
        ];
        $response = $this->sfdc->sendSfdcRequest($requestData);
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['success' => $response]);
    }
    
    /**
     * Function to return city data
     * @return string
     */
    public function getCityId($cityid)
    {
        $cityData = $this->cityFactory->create()
                ->getCollection()
                ->addFieldToFilter('bajaj_city_id', ['eq' => $cityid])
                ->addFieldToSelect('city_name')
                ->getFirstItem()
                ->getData();
        return $cityData['city_name'];
    }
}
