<?php
/**
 * BFL Cybage_ExpertReview
 *
 * @category   Cybage_ExpertReview Module
 * @package    BFL Cybage_ExpertReview
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\ExpertReview\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const PAGE_LIMIT = '500';
    
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
     * @var \Cybage\ExpertReview\Model\ExpertReviewFactory
     */
    protected $_expertReviewFactory;
    /**
     * Expert review API end point
     */
    const XML_REVIEW_API_ENDPOINT = 'api_config/exper_review_91/end_point';
    
    /**
     * Expert review API client
     */
    const XML_REVIEW_API_CLIENTID = 'api_config/exper_review_91/client_id';

    /**
     * 
     * @param \Cybage\ExpertReview\Model\ExpertReviewFactory $expertReviewFactory
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Psr\Log\LoggerInterface $customLogger
     */
    public function __construct(
        \Cybage\ExpertReview\Model\ExpertReviewFactory $expertReviewFactory,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $customLogger
    ) {
        $this->_curl = $curl;
        $this->_jsonHelper = $jsonHelper;
        $this->_scopeConfig = $scopeConfig;
        $this->_expertReviewFactory = $expertReviewFactory;
        $this->_logger = $customLogger;
        parent::__construct($context);
    }

    /**
     * getApiEndPoint
     * @return type
     */
    public function getApiEndPoint()
    {
        return $this->_scopeConfig->getValue(
            self::XML_REVIEW_API_ENDPOINT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * getApiClientId
     * @return type
     */
    public function getApiClientId()
    {
        return $this->_scopeConfig->getValue(
            self::XML_REVIEW_API_CLIENTID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * getExpertReview
     * @param type $cateId
     * @param type $SKU
     * @param int $pageNo
     * @return type
     * @throws Exception
     */
    public function getExpertReview($cateId, $SKU = null, $pageNo = 0)
    {
        if (is_null($this->getApiEndPoint()) || is_null($this->getApiClientId())) {
            throw new Exception(__("API configuration error"));
        }
        if (is_null($SKU)) {
            $url = $this->getApiEndPoint().'list/'.$cateId.'?clientId='.$this->getApiClientId().'&startRow='.$pageNo.'&limit='.self::PAGE_LIMIT;
            $this->_logger->info('API Endpoint '.$url);
            $totalProducts = $this->getReviewList($url);
            $this->_logger->info('Total products '.$totalProducts);
            if ($totalProducts > self::PAGE_LIMIT) {
                $maxPages = ceil(($totalProducts - self::PAGE_LIMIT)/self::PAGE_LIMIT);
                for ($pageNo=1; $pageNo <= $maxPages; $pageNo++) {
                    $startRow = self::PAGE_LIMIT * $pageNo;
                    $url = $this->getApiEndPoint().'list/'.$cateId.'?clientId='.$this->getApiClientId().'&startRow='.$startRow.'&limit='.self::PAGE_LIMIT;
                    $this->_logger->info('API Endpoint '.$url);
                    $this->getReviewList($url);
                }
            }
            return true;
        } else {
            $url = $this->getApiEndPoint().$cateId.'/'.$SKU.'?clientId='.$this->getApiClientId();
            return $this->getProductReview($url);
        }
    }

    /**
     * getReviewList
     * @param type $url
     * @return type
     */
    protected function getReviewList($url)
    {
        $response = $this->getApiResponse($url);
        if ($response['statusCode'] != 200 || $response['results']['exception'] == 1) {
            return __("API response issue");
        }
        
        $count = $response['results']['totalCount'];
        if ($count > 0) {
            $experReviews = $response['results']['products'];
            foreach ($experReviews as $review) {
                $this->saveExperReviews($review);
            }
        }
        return $count;
    }

    /**
     * getProductReview
     * @param type $url
     * @return type
     */
    protected function getProductReview($url)
    {
        $response = $this->getApiResponse($url);
        if ($response['statusCode'] != 200 || $response['results']['exception'] == 1) {
            return __("API response issue");
        }
        $experReviews = $response['results'];
        return $this->saveExperReviews($experReviews);
    }

    /**
     * saveExperReviews
     * @param type $experReview
     * @return type
     */
    protected function saveExperReviews($experReview)
    {
        try {
            $this->_logger->info('API Response > '.$experReview['BFL_product_id']);
                //save expert review
            $reviewData= ['rating'=> 0,
                'expert_rating' => '',
                'verdict' => '',
                'pros'=> '',
                'cons' => '',
                'reviewed_by' => '',
                'reviewed_date' => '',
                'spec_score' => '',
                'videos' => ''
            ];
            $reviewData['sku'] = $experReview['BFL_product_id'];
            $reviewData['reviewer'] = 1; //1 = 91 mobile
            if (isset($experReview['expert_review']) && !is_null($experReview['expert_review'])) {
                $reviewData['rating'] = $experReview['expert_review']['expert_rating'];
                $reviewData['expert_rating'] = $experReview['expert_review']['title'];
                $reviewData['verdict'] = $experReview['expert_review']['verdict'];
                $reviewData['pros'] = $this->_jsonHelper->jsonEncode($experReview['expert_review']['pros']);
                $reviewData['cons'] = $this->_jsonHelper->jsonEncode($experReview['expert_review']['cons']);
                $reviewData['reviewed_by'] = $experReview['expert_review']['author'];
                $reviewData['reviewed_date'] = $experReview['expert_review']['date'];
            }
            $reviewData['spec_score'] = $this->_jsonHelper->jsonEncode($experReview['spec_score_group']);
            $reviewData['videos'] = $this->_jsonHelper->jsonEncode($experReview['videos']);
            $expertReview = $this->_expertReviewFactory->create();
            $expertReview->load($reviewData['sku'], 'sku');
            if ($expertReview->getEntityId()) {
                $expertReview->addData($reviewData);
                $expertReview->setId($expertReview->getEntityId());
                $expertReview->save();
            } else {
                $expertReview->setData($reviewData)->save();
            }
            return;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * getApiResponse
     * @param type $url
     * @return type
     */
    protected function getApiResponse($url)
    {
        try {
            $this->_curl->get($url);
            //response will contain the output in form of JSON string
            $headers = ["Content-Type" => "application/json", "Content-Length" => "200"];
            $this->_curl->setHeaders($headers);
            $response = $this->_curl->getBody();
            return $this->_jsonHelper->jsonDecode($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
