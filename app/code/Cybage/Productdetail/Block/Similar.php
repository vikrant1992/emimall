<?php

/**
 * BFL Cybage_Productdetail
 *
 * @category   Cybage_Productdetail Block
 * @package    BFL Cybage_Productdetail
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Productdetail\Block;

/**
 * Class Similar
 */
class Similar extends \Magento\Framework\View\Element\Template
{

    const NUMBER_OF_PRODUCTS = 6;

    /**
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\Product $productRepository
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Catalog\Helper\ImageFactory $helperFactory
     * @param \Magento\Store\Model\App\Emulation $appEmulation
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus
     * @param \Magento\Catalog\Model\Product\Visibility $productVisibility
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product $productRepository,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Catalog\Helper\ImageFactory $helperFactory,
        \Magento\Store\Model\App\Emulation $appEmulation,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
        \Magento\Catalog\Model\Product\Visibility $productVisibility
    ) {
        $this->registry = $registry;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        $this->helperFactory = $helperFactory;
        $this->appEmulation = $appEmulation;
        $this->_storeManager = $storeManager;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        parent::__construct($context);
    }

    /**
     * Get similar products
     * @return array
     */
    public function getSimilarProducts()
    {

        $similarProductsCollection = [];
        $storeId = $this->_storeManager->getStore()->getId();
        $this->appEmulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
        $currentProduct = $this->registry->registry('current_product');
        $attributeSetId = $currentProduct->getAttributeSetId();
        $currentProductId = $currentProduct->getId();
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
        $collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
        $collection->addFieldToFilter('attribute_set_id', $attributeSetId);
        $collection->addFieldToFilter('entity_id', ['neq' => $currentProductId]);
        $collection->setPageSize(self::NUMBER_OF_PRODUCTS);
        $collection->getSelect()->orderRand();
        $productCollections  = $collection;
        foreach ($productCollections as $product) {
            $productCollection = [];
            if ($product->getEmiStartingAt()) {
                $emiStartingAt = number_format($product->getEmiStartingAt(), 0);
            } else {
                $emiStartingAt = '0';
            }
            $productCollection['id'] = $product->getId();
            $productCollection['url'] = $product->getProductUrl();
            $productCollection['name'] = $product->getName();
            $productCollection['emi_starting_at'] = $emiStartingAt;
            $imageUrl = $this->getImage($product, 'product_base_image')->getUrl();
            $productCollection['image'] = $imageUrl;
            
            $similarProductsCollection[] = $productCollection;
        }
        return $similarProductsCollection;
    }

    /**
     * Retrieve product image
     *
     * @param type $product
     * @param type $imageId
     * @return type
     */
    public function getImage($product, $imageId)
    {
        $image = $this->helperFactory->create()->init($product, $imageId)
                ->constrainOnly(true)
                ->keepAspectRatio(true)
                ->keepTransparency(true)
                ->keepFrame(false)
                ->resize(200, 300);
        return $image;
    }

    /**
     * getViewAllUrl
     * @return type
     */
    public function getViewAllUrl()
    {
        $currentProduct = $this->registry->registry('current_product');
        $categoryIds = $currentProduct->getCategoryIds();
        $data = [];
        $categories = $this->_categoryCollectionFactory->create()
            ->addIsActiveFilter()
            ->addAttributeToFilter('entity_id', $categoryIds);
        foreach ($categories as $category) {
            $data[$category->getLevel()] = $category->getUrl();
        }
        return $data;
    }
}
