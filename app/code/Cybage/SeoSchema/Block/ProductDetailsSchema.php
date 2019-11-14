<?php
/**
 * BFL Cybage_SeoSchema
 *
 * @category   Cybage_SeoSchema Block
 * @package    BFL Cybage_SeoSchema
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\SeoSchema\Block;

class ProductDetailsSchema extends \Magento\Framework\View\Element\Template
{
    /**
     * ENABLE_PRODUCT_SCHEMA
     */
    const ENABLE_PRODUCT_SCHEMA = 'seo_config/product/enable_product_schema';

    /**
     * BRAND_ATTRIBUTE_CODE
     */
    const BRAND_ATTRIBUTE_CODE = 'brand';

    /**
     * SD_BEST_RATING
     */
    const SD_BEST_RATING = '5';

    /**
     * SD_WORST_RATING
     */
    const SD_WORST_RATING = '0';

    /**
     * SD_SCHEMA_URL
     */
    const SD_SCHEMA_URL = "http://schema.org/";

    /**
     * SD_PRODUCT_TYPE
     */
    const SD_PRODUCT_TYPE = "Product";
    
    /**
     * SD_THING
     */
    const SD_THING = "Thing";
    
    /**
     * SD_AGGREGATERATING
     */
    const SD_AGGREGATERATING = "AggregateRating";
    
    /**
     * @var \Cybage\SeoSchema\Helper
     */
    protected $_helper;
    
    /**
     * @var \Cybage\Attributemapping\Helper\Data
     */
    protected $_attrMappinghelper;

    /**
     * @var ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\Review\Model\ReviewFactory
     */
    protected $_reviewFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Cybage\SeoSchema\Helper\Data $helper
     * @param \Cybage\Attributemapping\Helper\Data $attrMappinghelper
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Review\Model\ReviewFactory $reviewFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Cybage\SeoSchema\Helper\Data $helper,
        \Cybage\Attributemapping\Helper\Data $attrMappinghelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->registry = $registry;
        $this->_helper = $helper;
        $this->_attrMappinghelper = $attrMappinghelper;
        $this->_productFactory = $productFactory;
        $this->_reviewFactory = $reviewFactory;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Is enabled?
     *
     * @return bool
     */
    public function isProductSchemaEnabled()
    {
        return $this->_helper->getConfigValue(self::ENABLE_PRODUCT_SCHEMA);
    }

    /**
     * Get current product
     *
     * @return mixed
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * get product Structured Data
     *
     * @return string
     */
    public function showProductStructuredData()
    {
        if ($currentProduct = $this->getCurrentProduct()) {
            $productId = $currentProduct->getId() ? $currentProduct->getId() : $this->request->getParam('id');
            $product = $this->_productFactory->create()->load($productId);
            $sku = $currentProduct->getSku();
            
            $productStructuredData = array(
                "@context" => self::SD_SCHEMA_URL,
                "@type" => self::SD_PRODUCT_TYPE,
                "name" => $currentProduct->getName(),
                "sku" => $sku,
                "url" => $currentProduct->getProductUrl()
            );

            $description = $this->getProductDescription($sku);
            if (!empty($description)) {
                $productStructuredData['description'] = $description;
            }

            $productImages = $this->getProductImages($product);
            if (is_array($productImages) && !empty($productImages)) {
                $productStructuredData['image'] = $productImages;
            }

            $brandName = $this->getBrandName($currentProduct);
            if (!empty($brandName)) {
                $brand = array(
                    '@type' => self::SD_THING,
                    'name' => $brandName
                );
                $productStructuredData['brand'] = $brand;
            }

            $reviewCount = $this->getReviewCount($currentProduct);
            if ($reviewCount) {
                $ratingSummary = $this->getRatingSummary($currentProduct);

                $aggregateRating = array(
                    "@type" => self::SD_AGGREGATERATING,
                    "bestRating" => self::SD_BEST_RATING,
                    "worstRating" => self::SD_WORST_RATING,
                    "ratingValue" => $ratingSummary,
                    "reviewCount" => $reviewCount
                );
                $productStructuredData['aggregateRating'] = $aggregateRating;
            }

            return $this->_helper->createStructuredData($productStructuredData);
        }
    }

    /**
     * get product description
     *
     * @return string
     */
    public function getProductDescription($sku)
    {
        $productDescription = '';
        $attributeData = $this->_attrMappinghelper->getAttributes($sku);
        if (isset($attributeData["short_descriptor"]) && !empty($attributeData["short_descriptor"])) {
            $productDescription = trim(strip_tags($attributeData["short_descriptor"]));
        }
        
        return $productDescription;
    }

    /**
     * get product images
     *
     * @return array
     */
    public function getProductImages($product)
    {
        $images = array();

        $mediaGalleries = $product->getMediaGalleryEntries();
        foreach ($mediaGalleries as $mediaGallery) {
            $imageFile = $mediaGallery->getFile();

            if (!empty($imageFile)) {
                $productImage = $this->getUrl('pub/media/catalog') . 'product' . $imageFile;
                $images[] = $productImage;
            }
        }

        return $images;
    }

    /**
     * Get brand name of product
     *
     * @return string
     */
    public function getBrandName($currentProduct)
    {
        $brandName = '';

        if (is_object($currentProduct->getCustomAttribute(self::BRAND_ATTRIBUTE_CODE))) {
            $optionId =  $currentProduct->getCustomAttribute(self::BRAND_ATTRIBUTE_CODE)->getValue();

            if (!empty($optionId)) {
                $attributeId = $currentProduct->getResource()->getAttribute(self::BRAND_ATTRIBUTE_CODE);
                if ($attributeId->usesSource()) {
                    $brandName = $attributeId->getSource()->getOptionText($optionId);
                }
            }
        }

        return $brandName;
    }

    /**
     * Get Review Count
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getReviewCount($product)
    {
        if (!$product->getRatingSummary()) {
            $this->getEntitySummary($product);
        }

        return $product->getRatingSummary()->getReviewsCount();
    }

    /**
     * Get Rating Summary
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getRatingSummary($product)
    {
        if (!$product->getRatingSummary()) {
            $this->getEntitySummary($product);
        }

        return $product->getRatingSummary()->getRatingSummary();
    }

    /**
     * Get Entity Summary
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getEntitySummary($product)
    {
        $this->_reviewFactory->create()->getEntitySummary($product, $this->_storeManager->getStore()->getId());
    }
}
