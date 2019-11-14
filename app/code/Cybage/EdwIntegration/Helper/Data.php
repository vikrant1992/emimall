<?php
/**
 * BFL Cybage_EdwIntegration
 *
 * @category   Cybage_EdwIntegration Helper
 * @package    BFL Cybage_EdwIntegration
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\EdwIntegration\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     */
    protected $_curl;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $_jsonHelper;

    /**
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_curl = $curl;
        $this->_jsonHelper = $jsonHelper;
        
        parent::__construct($context);
    }

    /**
     * Return API response
     *
     * @param $url $params $headers
     * @return json api response
     */
    public function getApiResponse($url, $params = '', $headers = array())
    {
        try {
            if (!empty($headers) && is_array($headers)) {
                $this->_curl->setHeaders($headers);
            }

            //if the method is post
            $this->_curl->post($url, $params);

            //response will contain the output in form of JSON string
            $responseStatusCode = $this->_curl->getStatus();

            //response will contain the output in form of JSON string
            $responseBody = $this->_curl->getBody();

            $arrResponseBody = $this->_jsonHelper->jsonDecode($responseBody);

            $arrResponse = array("responseStatusCode" => $responseStatusCode, "responseBody" => $arrResponseBody);

            return $arrResponse;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Return value for config path
     *
     * @param $configPath
     * @return string config value
     */
    public function getConfigValue($configPath = '')
    {
        return $this->_scopeConfig->getValue($configPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
    }
}
