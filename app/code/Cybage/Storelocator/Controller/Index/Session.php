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

use Magento\Framework\Controller\ResultFactory;

class Session extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface CookieManagerInterface
     */
    private $cookieManager;

    /**
     * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory CookieMetadataFactory
     */
    private $cookieMetadataFactory;
    
    /**
     * Constructor
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Cybage\Storelocator\Model\CityFactory $cityFactory
     * @param \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     * @param \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Cybage\Storelocator\Model\CityFactory $cityFactory,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory
    ) {
        $this->customerSession = $customerSession;
        $this->cityFactory = $cityFactory;
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $data = $this->getRequest()->getPostValue();
        $this->customerSession->unsPincodeFilter();
        $this->customerSession->unsGroupFilter();
        $this->customerSession->unsCategoryFilter();
        
        if (isset($data['city']) && !empty($data['city'])) {
            $cityData = $this->cityFactory->create()
                    ->getCollection()
                    ->addFieldToFilter('city_name', ['eq' => strtoupper($data['city'])])
                    ->getFirstItem()
                    ->getData();
            if (isset($cityData['city_name'])) {
                $this->customerSession->setBflCustomerCityName($cityData['city_name']);
                $publicCookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata();
                $publicCookieMetadata->setDurationOneYear();
                $publicCookieMetadata->setPath('/');
                $this->cookieManager->setPublicCookie(
                                'city', $cityData['city_name'], $publicCookieMetadata
                );
				$this->customerSession->unsPincodeFilter();
                $this->customerSession->unsGroupFilter();
                $this->customerSession->unsCategoryFilter();
				unset($data['pincode']);
                unset($data['group']);
            }
        }
        if (isset($data['categorylob'])) {
            $this->customerSession->setCategorylob($data['categorylob']);
        }

        if (isset($data['category']) && !empty($data['category'])) {
            $this->customerSession->setCategoryFilter($data['category']);
        }

        if (isset($data['group']) && !empty($data['group'])) {
            $this->customerSession->setGroupFilter($data['group']);
        }

        if (isset($data['pincode']) && !empty($data['pincode'])) {
            $this->customerSession->setPincodeFilter($data['pincode']);
        }

        if (isset($data['clearall'])) {
            $this->customerSession->unsPincodeFilter();
            $this->customerSession->unsGroupFilter();
            $this->customerSession->unsCategoryFilter();
            $this->customerSession->unsBflModelCode();
        }

        if (isset($data['firstName'])) {
            $this->customerSession->setBflCustomerName($data['firstName']);
        }
        
        if (isset($data['modelCode'])) {
            $this->customerSession->setBflModelCode($data['modelCode']);
        }
        
        if (isset($data['modelName'])) {
            $this->customerSession->setBflModelName($data['modelName']);
        }
        
        if (isset($data['firstName'])) {
            $this->customerSession->setBflCustomerName($data['firstName']);
        }
        
        if(isset($data['findStore'])){
            $loggedIn = false;
            $isloggedIn = $this->customerSession->isLoggedIn();
            if($isloggedIn){
                $loggedIn = true;
            }
            $data = ['isLoggedIn'=> $loggedIn];
            $resultJson->setData($data);
            return $resultJson;
        }
    }
}
