<?php
/**
 * BFL Cybage_Homepage
 *
 * @category   Cybage_Homepage Module
 * @package    BFL Cybage_Homepage
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\Homepage\Block\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Catalog\Helper\Image as ImageHelper;

class Details extends \Magento\Framework\View\Element\Template
{
    
    /**
     *
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    
    /**
    * @var \Magento\Framework\App\Config\ScopeConfigInterface
    */
    protected $scopeConfig;
    
    /**
     *
     * @var ImageHelper 
     */
    protected $imageHelper;
    
    /**
    * Quick compare SKUs config path
    */
    const XML_PATH_COMPARE_SKUS = 'homepage/quickcompare/skus';
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param ScopeConfigInterface $scopeConfig
     * @param ImageHelper $imageHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ProductRepositoryInterface $productRepository,
        ScopeConfigInterface $scopeConfig,
        ImageHelper $imageHelper,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
        $this->imageHelper = $imageHelper;
        parent::__construct($context, $data);
    }
    
    /**
     * Get Product Data By SKU
     * @param string $sku
     * @return object
     */
    public function getProductData($sku) {
        return  $this->productRepository->get($sku);
    }
    
    /**
     * Get SKUs To Compare along with Compare URL
     * @return array
     */
    public function getSkusToCompare() {
        $skusArray = [];
        $skus = $this->scopeConfig->getValue(self::XML_PATH_COMPARE_SKUS, ScopeInterface::SCOPE_STORE);
        if(!empty($skus)){
            $skuPairs = explode('|', $skus);
            foreach($skuPairs as $skupair){
                $skuAndNameArray = explode(',',$skupair);
                $skuArray = array_map(function($item) {
                    return trim($item, ' \'"');
                }, $skuAndNameArray);
                $skusArray[] = $skuArray;
            }
        }
        return $skusArray;
    }
    
    /**
     * Get Product Image URL
     * @param int $sku
     * @return string
     */
    public function getProductImageUrl($sku){
        $product = $this->productRepository->get($sku);
        $imageUrl = $this->imageHelper->init($product, 'product_base_image')
            ->constrainOnly(true)
            ->keepAspectRatio(true)
            ->keepTransparency(true)
            ->keepFrame(false)
            ->getUrl();
        return $imageUrl;
    }
}
