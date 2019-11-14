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
namespace Cybage\Storelocator\Block\Index;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Cybage\Storelocator\Block\Index\Index as storeLocatorBlock;
use \Magento\Framework\App\Request\Http;

class Viewmore extends Template {
    
    /**
     * @var $_resource
     */
    private $_resource;
    
    /**
     * @var $scopeConfig
     */
    protected $scopeConfig;
    
    /**
     * @var $request
     */
    protected $request;
    
    /**
     * @var $storeLocatorBlock
     */
    protected $storeLocatorBlock;
    
    /**
     * @var $customerSession
     */
    protected $customerSession;
    
    /**
     * Function to return 
     * @return parent::_prepareLayout()
     */
    public function _prepareLayout() {
        return parent::_prepareLayout();
    }
    
     /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param ResourceConnection $resource
     * @param array $data
     * @param ScopeConfigInterface $scopeConfig
     * @param storeLocatorBlock $storeLocatorBlock
     * @param \Magento\Customer\Model\Session $customerSession
     * @param Http $request
     * 
     */
    public function __construct(Context $context, ResourceConnection $resource, array $data = [], ScopeConfigInterface $scopeConfig, storeLocatorBlock $storeLocatorBlock,\Magento\Customer\Model\Session $customerSession,Http $request) {
        $this->_resource = $resource;
        $this->scopeConfig = $scopeConfig;
        $this->storeLocatorBlock = $storeLocatorBlock;
        $this->customerSession = $customerSession;
        $this->request = $request;
        parent::__construct($context, $data);
    }
    
    /**
     * Function to return all stores collection
     * @return array
     */
    public function getSoresCollection() {
       $params = $this->request->getParams();
       if(isset($params) && isset($params['lastId'])){
            $id=$params['lastId'];
            $data =$this->storeLocatorBlock->getStoreList();
            $storesPerPage =$this->storeLocatorBlock->getNumberofStoresPerpage();
            $paginatedData = array_slice($data,$id,$storesPerPage,true);
            return $paginatedData;
       }else{
           return array();
       }
    }
    
    /**
     * Function to return content copy configuration value
     * @return string
     */
    public function getNumberofStoresPerpage()
    {
        return $this->scopeConfig->getValue("storelocator/mapconfiguration/stores_per_page");
    }
    
    /**
     * Function to return content copy configuration value
     * @return string
     */
    public function getAllStores(){
        return $data =$this->storeLocatorBlock->getStoreList();
    }
    
    /**
     * Function to return Ajax parameters
     * @return array
     */
    public function getajaxParams(){
        return $params = $this->request->getParams();
    }

}
