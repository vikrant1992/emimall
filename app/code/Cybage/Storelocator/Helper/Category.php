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

namespace Cybage\Storelocator\Helper;

use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * Category helper
 */
class Category extends \Magento\Framework\App\Helper\AbstractHelper {

    const PATH = 'catalog/category/';
    const API_URL_PATH = 'storelocator/storelocator/api_url';
    const API_KEY_PATH = 'storelocator/storelocator/api_key';
    const IPINFO_API_PATH = 'storelocator/storelocator/ipinfo_api';
    const GEOLOC_API_PATH = 'storelocator/storelocator/geolocation_api_url';

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     *
     * @var AttributeSetRepositoryInterface
     */
    protected $attributeSet;

    /**
     *
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param AttributeSetRepositoryInterface $attributeSet
     * @param CustomerSession $customerSession
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
    \Magento\Framework\App\Helper\Context $context, \Magento\Store\Model\StoreManagerInterface $storeManager, AttributeSetRepositoryInterface $attributeSet, CustomerSession $customerSession, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\View\Asset\Repository $assetRepo
    ) {
        $this->_storeManager = $storeManager;
        $this->attributeSet = $attributeSet;
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
        $this->_assetRepo = $assetRepo;
        parent::__construct($context);
    }

    /**
     * Category Icon URL
     * @param $category
     */
    public function getCategoryIconUrl($category) {
        $url = false;
        $file = $category->getCategoryIcon();
        if ($file) {
            if (is_string($file)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                        ) . self::PATH . $file;
            }
        }
        return $url;
    }

    /**
     * Is Customer Logged In
     * @return boolean
     */
    public function isCustomerLoggedIn() {
        if ($this->customerSession->isLoggedIn()) {
            return true;
        }
        return false;
    }

    /**
     * Get Category Lob by Attribute set Id
     * @param int $attributeSetId
     * @return string
     */
    public function getCategoryLob($attributeSetId) {
        if ($attributeSetId) {
            $attributeSetRepository = $this->attributeSet->get($attributeSetId);
            $categoryLob = $attributeSetRepository->getData('attribute_set_lob');
            return $categoryLob;
        }
    }

    /**
     * Function for google API url config setting
     * @return type
     */
    public function getGoogleApiUrl() {
        return $this->scopeConfig->getValue(self::API_URL_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Function for google API key config setting
     * @return type
     */
    public function getGoogleApiKey() {
        return $this->scopeConfig->getValue(self::API_KEY_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Function for IP Info API url config setting
     * @return type
     */
    public function getIpInfoApiUrl() {
        return $this->scopeConfig->getValue(self::IPINFO_API_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Return popular cities
     * @retrn array
     */
    public function getPopulaCities() {
        $popularCities = [
            'Mumbai' => [
                'data-lat' => '19.075983',
                'data-long' => '72.877655',
                'data-city' => 'Mumbai',
                'img' => $this->_assetRepo->getUrl("images/mumbai.svg")
            ],
            'Delhi' => [
                'data-lat' => '28.632430',
                'data-long' => '77.218790',
                'data-city' => 'Delhi',
                'img' => $this->_assetRepo->getUrl("images/delhi.svg")
            ],
            'Hyderabad' => [
                'data-lat' => '13.245980',
                'data-long' => '77.705840',
                'data-city' => 'Hyderabad',
                'img' => $this->_assetRepo->getUrl("images/hyderabad.svg")
            ],
            'Chennai' => [
                'data-lat' => '13.072090',
                'data-long' => '80.201859',
                'data-city' => 'Chennai',
                'img' => $this->_assetRepo->getUrl("images/chennai.svg")
            ],
            'Bangalore' => [
                'data-lat' => '12.9716',
                'data-long' => '77.5946',
                'data-city' => 'Bangalore',
                'img' => $this->_assetRepo->getUrl("images/bangalore.svg")
            ],
            'Jaipur' => [
                'data-lat' => '26.9124',
                'data-long' => '75.7873',
                'data-city' => 'Jaipur',
                'img' => $this->_assetRepo->getUrl("images/group-9.svg")
            ],
            'Pune' => [
                'data-lat' => '18.516726',
                'data-long' => '73.856255',
                'data-city' => 'Pune',
                'img' => $this->_assetRepo->getUrl("images/pune.svg")
            ],
            'kolkata' => [
                'data-lat' => '22.5726',
                'data-long' => '88.3639',
                'data-city' => 'kolkata',
                'img' => $this->_assetRepo->getUrl("images/kolkata.svg")
            ],
        ];
        return $popularCities;
    }

    /**
     * Function for Geo Location API url config setting
     * @return type
     */
    public function getGeoLocationApiUrl() {
        return $this->scopeConfig->getValue(self::GEOLOC_API_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

}
