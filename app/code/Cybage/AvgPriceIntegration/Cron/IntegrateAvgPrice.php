<?php
/**
 * BFL Cybage_AvgPriceIntegration
 *
 * @category   Cybage_AvgPriceIntegration Module
 * @package    BFL Cybage_AvgPriceIntegration
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\AvgPriceIntegration\Cron;

class IntegrateAvgPrice
{
    /**
     * AVG PRICE API SUBSCRIPTION KEY
     */
    const AVG_PRICE_API_SUBSCRIPTION_KEY = 'api_config/AVG_PRICE/avg_price_api_subscription_key';

    /**
     * AVG PRICE API URL
     */
    const AVG_PRICE_API_URL = 'api_config/AVG_PRICE/avg_price_api_url';

    /**
     * @var \Cybage\AvgPriceIntegration\Helper
     */
    protected $_helper;

    /**
     * @var \Cybage\PstpIntegration\Helper
     */
    protected $_pstpHelper;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productRepository;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product
     */
    protected $_productResourceModel;

    /**
     * Constructor
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Catalog\Model\ResourceModel\Product $productResourceModel
     * @param \Cybage\AvgPriceIntegration\Helper\Data $helper
     * @param \Cybage\PstpIntegration\Helper $pstpHelper
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product $productResourceModel,
        \Cybage\AvgPriceIntegration\Helper\Data $helper,
        \Cybage\PstpIntegration\Helper\Data $pstpHelper
    ) {
        $this->_productResourceModel = $productResourceModel;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productRepository = $productRepository;
        $this->_helper = $helper;
        $this->_pstpHelper = $pstpHelper;
    }

    /**
     * Method executed when cron runs in server
     */
    public function execute()
    {
        $this->updateProductsAvgPriceEmiStartingAt();

        return $this;
    }

    /**
     * Update products Avg. Price and EMI Starting At
     *
     * @return None
     */
    public function updateProductsAvgPriceEmiStartingAt()
    {
        // Use factory to create a new product collection
        $productCollection = $this->_productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');

        foreach ($productCollection as $product) {
            $productId = $product->getEntityId();
            $modelCode = $product->getModelCode();

            $arrResponseData = $this->getAvgPriceApiResponse($modelCode);

            if (!empty($arrResponseData['responseCode'])) {
                if ($arrResponseData['responseCode'] == '00' && $arrResponseData['responseMessage'] == 'SUCCESS') {
                    $averagePrice = empty($arrResponseData['averagePrice']) ? '0' : $arrResponseData['averagePrice'];
                    $emiStartingAmount = empty($arrResponseData['emiStartingAmount']) ? '0' : $arrResponseData['emiStartingAmount'];

                    $product->setPrice($averagePrice);
                    $product->setEmiStartingAt($emiStartingAmount);
                    
                    $this->_productResourceModel->saveAttribute($product, 'price');
                    $this->_productResourceModel->saveAttribute($product, 'emi_starting_at');
                }
            }
        }
    }

    /**
     * Get Avg Price API Response
     *
     * @return json|string
     */
    public function getAvgPriceApiResponse($modelCode = '')
    {
        $result = '';
        $apiSubscriptionKey = $this->_helper->getConfigValue(self::AVG_PRICE_API_SUBSCRIPTION_KEY);
        $apiUrl = $this->_helper->getConfigValue(self::AVG_PRICE_API_URL);

        // Generate Access Token
        $generatedToken = $this->_pstpHelper->getAccessToken();
        $accessToken = \Cybage\PstpIntegration\Helper\Data::TOKEN_TYPE.$generatedToken;

        if (!empty($modelCode)) {
            // Generate API Header
            $arrApiHeaders = array(
                                "Content-Type" => "application/json",
                                "Ocp-Apim-Subscription-Key" => $apiSubscriptionKey,
                                "Authorization" => $accessToken,
                             );

            // Generate API Body
            $arrParams = array(
                            "model" => $modelCode
                         );
            $strParams = json_encode($arrParams);

            $arrResponseData = $this->_helper->getApiResponse($apiUrl, $strParams, $arrApiHeaders);

            $responseStatusCode = $arrResponseData["responseStatusCode"];
            if ($responseStatusCode == 200) {
                $result = $arrResponseData["responseBody"];
            }
        }

        return $result;
    }
}
