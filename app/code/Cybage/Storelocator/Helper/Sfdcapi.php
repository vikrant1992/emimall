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

use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * SFDC API helper
 */
class Sfdcapi extends \Magento\Framework\App\Helper\AbstractHelper {

    const SUBSCRIPTION_KEY = 'api_config/sfdc/ocp_apim_subscription_key';
    const API_URL = 'api_config/sfdc/api_url';
    const TOKEN_URL = 'api_config/sfdc/token_url';
    const SFDC_FOR_ALL = 'api_config/sfdc/sfdc_enabled';
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var ZendClientFactory
     */
    private $httpClientFactory;
    
    /**
     * @var Json
     */
    private $json;
    
    /**
     * Constructor
     * 
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        ZendClientFactory $httpClientFactory,
        Json $json,
        \Magento\Framework\App\Filesystem\DirectoryList $directory_list,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Cybage\PstpIntegration\Helper\Data $pstpHelper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->httpClientFactory = $httpClientFactory;
        $this->json = $json;
        $this->directory_list = $directory_list;
        $this->_date =  $date;
        $this->_pstpHelper = $pstpHelper;
        parent::__construct($context);
    }

    /**
     * Get Subscription Key config path
     * @return type
     */
    public function getSubscriptionKey() {
        return $this->scopeConfig->getValue(self::SUBSCRIPTION_KEY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get sfdc for all config path
     * @return type
     */
    public function getSfdcforall() {
        return $this->scopeConfig->getValue(self::SFDC_FOR_ALL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get API URL config path
     * @return type
     */
    public function getApiUrl() {
        return $this->scopeConfig->getValue(self::API_URL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Token URL config path
     * @return type
     */
    public function getTokenUrl() {
        return $this->scopeConfig->getValue(self::TOKEN_URL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function sendSfdcRequest($requestData) {
        $client = $this->httpClientFactory->create();
        $request = [
            "custType" => $requestData['custType'],
            "customerMobileNumber" => $requestData['customerMobileNumber'],
            "customerName" => $requestData['customerName'],
            "dealerCity" => $requestData['dealerCity'],
            "dealerMobileNumber" => $requestData['dealerMobileNumber'],
            "dealerName" => $requestData['dealerName'],
            "finnOneModelCode" => $requestData['finnOneModelCode'],
            "schemeCode" => $requestData['schemeCode'],
            "sourceUniqueID" => $requestData['sourceUniqueID'],
            "maximumTenure" => $requestData['maximumTenure'],
            "modelName" => $requestData['modelName'],
            "source" => $requestData['source'],
            "channel" => $requestData['channel']
        ];

        try {
            // Generate Access Token
            $generatedToken = $this->_pstpHelper->getAccessToken();
            $accessToken = \Cybage\PstpIntegration\Helper\Data::TOKEN_TYPE.$generatedToken;
            $client->setUri($this->getApiUrl());
            $client->setConfig(['maxredirects' => 0, 'timeout' => 30]);
            $client->setHeaders(['Ocp-Apim-Subscription-Key: ' . $this->getSubscriptionKey(). '']);
            $client->setHeaders(['Authorization' => $accessToken]);
            $client->setRawData($this->json->serialize($request), 'application/json');
            $client->setMethod(\Zend_Http_Client::POST);
            $responseBody = $client->request()
                ->getBody();
            $data = $this->json->unserialize($responseBody);

            /* Log response to file */
            $target_path = $this->directory_list->getPath('var') . '/log/sfdc';
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
            $writer = new \Zend\Log\Writer\Stream($target_path . '/' . $this->_date->date()->format('d-m-Y') . '.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
            $logger->info("SFDC", array('Request', $request, true));
            $logger->info("SFDC", array('Response', $data, true));
            /* End of logger */
            
        } catch (\Exception $e) {
            throw new LocalizedException(
            __('Something went wrong.')
            );
        }
        return $data['responseCode'];
    }
}
