<?php
/**
 * BFL Cybage_EdwIntegration
 *
 * @category   Cybage_EdwIntegration Block
 * @package    BFL Cybage_EdwIntegration
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\EdwIntegration\Controller\Index;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{
        /**
     * EDW API SUBSCRIPTION KEY
     */
    const EDW_API_SUBSCRIPTION_KEY = 'api_config/EDW/edw_api_subscription_key';

    /**
     * EDW_API_URL
     */
    const EDW_API_URL = 'api_config/EDW/edw_api_url';

    /**
     * MAX_EMI_SCHEMES
     */
    const MAX_EMI_SCHEMES = 2;

    /**
     * @var \Cybage\EdwIntegration\Helper
     */
    protected $_helper;

    /**
     * @var \Cybage\PstpIntegration\Helper
     */
    protected $_pstpHelper;

    /**
     * @var productEmiStartingAt
     */
    public $productEmiStartingAt;

    protected $_pageFactory;

    protected $_postFactory;

    /**
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Cybage\EdwIntegration\Helper\Data $helper
     * @param \Cybage\PstpIntegration\Helper\Data $pstpHelper
     * @param \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     * @return type
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Cybage\EdwIntegration\Helper\Data $helper,
        \Cybage\PstpIntegration\Helper\Data $pstpHelper,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory
    ) {
        $this->_helper = $helper;
        $this->_pstpHelper = $pstpHelper;
        $this->cookieManager = $cookieManager;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    /**
     * Execute
     * @return type html
     */
    public function execute()
    {
        $schemesData = [];
        $content = '';
        $result = $this->_resultJsonFactory->create();
        $resultPage = $this->_resultPageFactory->create();
        $post = $this->getRequest()->getPostValue();
        $modelId = $post['model_code'];
        $indicativePrice = $post['indicativePrice'];
        $city = $this->cookieManager->getCookie('city');

        $arrResponseData = $this->getEdwApiResponse($modelId, $city, $indicativePrice);
        if (!empty($arrResponseData['emiCardMetaSearchDetails'])) {
            $schemesData = $this->findTop3Schemes($arrResponseData['emiCardMetaSearchDetails']);
        }
        $data = array('schemes'=>$schemesData);
        $block = $resultPage->getLayout()
                ->createBlock('Cybage\EdwIntegration\Block\View')
                ->setTemplate('Cybage_EdwIntegration::view.phtml')
                ->setData('data', $data)
                ->toHtml();

        $result->setData(['output' => $block]);
        return $result;
    }

    /**
     * Find top 3 schemes from all available schemes
     * @param array
     * @return array
     */
    protected function findTop3Schemes($arrEmiData)
    {
        array_multisort(array_column($arrEmiData, 'grossTenure'), SORT_DESC, SORT_NUMERIC, array_column($arrEmiData, 'downpayment'), SORT_ASC, SORT_NUMERIC, $arrEmiData);

        $arrSchemesData = array();

        $intSchemeCnt = 1;
        foreach ($arrEmiData as $val) {
            $grossTenure = $val['grossTenure'];
            if (!array_key_exists($grossTenure, $arrSchemesData)) {
                $downpayment = empty($val['downpayment']) ? '0.00' : $val['downpayment'];
                $modelPrice = $val['modelPrice'];

                if ($downpayment > 0 && $modelPrice > $downpayment) {
                    $emiStartingAt = ($modelPrice - $downpayment)/ $grossTenure;
                } else {
                    $emiStartingAt = ($modelPrice)/ $grossTenure;
                }

                $downpayment = number_format($downpayment);
                $emiStartingAt = number_format(round($emiStartingAt, 0));

                if ($intSchemeCnt == 0) {
                    $emiAdditionalCss = 'borderfinds';
                } else {
                    $emiAdditionalCss = '';
                }

                $arrSchemesData[$val['grossTenure']] = array(
                    'grossTenure' => $grossTenure,
                    'downpayment' => $downpayment,
                    'emiStartingAt' => $emiStartingAt,
                    'modelPrice' => $modelPrice,
                    'emiAdditionalCss' => $emiAdditionalCss
                    );
                if ($intSchemeCnt == 0) {
                    $this->productEmiStartingAt = $emiStartingAt;
                }

                if ($intSchemeCnt > self::MAX_EMI_SCHEMES) {
                    break;
                }
                $intSchemeCnt++;
            }
        }

        return $arrSchemesData;
    }

    /**
     * Return EDW API response
     *
     * @param modelId, city, $indicative_price
     * @return json response
     */
    public function getEdwApiResponse($modelId = '', $city = '', $indicativePrice = 0)
    {
        $result = '';
        $edwApiSubscriptionKey = $this->_helper->getConfigValue(self::EDW_API_SUBSCRIPTION_KEY);
        $edwApiUrl = $this->_helper->getConfigValue(self::EDW_API_URL);

        if (!empty($modelId) && !empty($city)) {
            // Generate Access Token
            $generatedToken = $this->_pstpHelper->getAccessToken();
            $accessToken = \Cybage\PstpIntegration\Helper\Data::TOKEN_TYPE.$generatedToken;

            // Generate API Header
            $arrApiHeaders = array(
                                "Content-Type" => "application/json",
                                "Ocp-Apim-Subscription-Key" => $edwApiSubscriptionKey,
                                "Authorization" => $accessToken,
                             );

            // Generate API Body
            $arrParams = array(
                "model" => $modelId,
                "city" => $city,
                "indicativePrice" => $indicativePrice
             );
            $strParams = json_encode($arrParams);

            $arrResponseData = $this->_helper->getApiResponse($edwApiUrl, $strParams, $arrApiHeaders);

            $responseStatusCode = $arrResponseData["responseStatusCode"];
            if ($responseStatusCode == 200) {
                $result = $arrResponseData["responseBody"];
            }
        }
        return $result;
    }
}
