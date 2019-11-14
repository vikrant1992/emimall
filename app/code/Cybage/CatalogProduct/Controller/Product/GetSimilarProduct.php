<?php

/**
 * BFL CatalogProduct
 *
 * @category   CatalogProduct Module
 * @package    BFL CatalogProduct
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\CatalogProduct\Controller\Product;

use Magento\Catalog\Api\ProductRepositoryInterface as ProductRepository;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;

class GetSimilarProduct extends \Magento\Framework\App\Action\Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
	
    const MAX_COUNT = '3';
	
	const NA_FLAG = 'NA';
	
	const URL_EXT = '.html';
    
	protected $_productRepository;
	
	protected $_product;
	
	protected $_category;
	
	const NUMBER_OF_PRODUCTS = 6;
	
	/**
     *
     * @var \Magento\Eav\Model\Config
     */
	protected $eavConfig;
	
    /**
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Visitor $customerVisitor
     * @param \Magento\Catalog\Model\Product\Compare\ListCompare $catalogProductCompareList
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Validator $formKeyValidator
     * @param PageFactory $resultPageFactory
     * @param \Magento\Catalog\Helper\Product\Compare $compareHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Visitor $customerVisitor,
        \Magento\Catalog\Model\Product\Compare\ListCompare $catalogProductCompareList,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Validator $formKeyValidator,
        PageFactory $resultPageFactory,
        ProductRepository $productRepository,
		\Magento\Catalog\Model\Product $product,
		\Magento\Catalog\Model\Category $category,
		\Magento\Eav\Model\Config $eavConfig,
		\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
		\Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
		\Magento\Catalog\Model\Product\Visibility $productVisibility,
        \Magento\Catalog\Helper\Product\Compare $compareHelper
    ) {
		$this->compareHelper = $compareHelper;
        $this->_storeManager = $storeManager;
        $this->_customerSession = $customerSession;
        $this->_customerVisitor = $customerVisitor;
        $this->_catalogProductCompareList = $catalogProductCompareList;
        $this->_formKeyValidator = $formKeyValidator;
        $this->resultPageFactory = $resultPageFactory;
        $this->_productRepository = $productRepository;
        $this->_product = $product;
        $this->_category = $category;
		$this->eavConfig = $eavConfig;
		$this->_productCollectionFactory = $productCollectionFactory;
		$this->productStatus = $productStatus;
		$this->productVisibility = $productVisibility;
        parent::__construct($context);
    }

    public function execute()
    {
		$requestParams = $this->getRequest()->getParams();
		$productId = isset($requestParams['product_id']) ? (int)$requestParams['product_id'] : null;
		$productData = $this->getSimilarProduct($productId);
		$result = [];
		$resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
		$result = [
                        'success' => true,
                        'data' => $productData
                    ];
		return $resultJson->setData($result);		
    }
    
	/**
     * Get Product Data from ID
     * @param int $productId
	 * @return array
     */
    public function getSimilarProduct($productId)
    {
		if ($productId) {
			$product = $this->_product->load($productId);
			$collection = $this->_productCollectionFactory->create();
			$collection->addAttributeToSelect('*');
			$collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
			$collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
			$collection->addFieldToFilter('attribute_set_id', $product->getAttributeSetId());
			$collection->addFieldToFilter('entity_id', ['neq' => $productId]);
			$collection->setPageSize(self::NUMBER_OF_PRODUCTS);
			$collection->getSelect()->orderRand();
			$productCollections  = $collection;
			$response = array();
			foreach ($productCollections as $value) {
				$response[] = $this->getProductData($value->getId());
			}			
			return $response;	
        }        
    }
	
	/**
     * Get Product Data from ID
     * @param int $productId
	 * @return array
     */
    public function getProductData($productId)
    {
		if ($productId) {
			$response = array();
            try {
				$product = $this->_product->load($productId);
				$assignedCategoryIds = $product->getCategoryIds();
				$category = $this->_category->load(reset($assignedCategoryIds));
				$productBrandLabel = $this->getOptionIdFromLabel('catalog_product', 'brand_new', $product->getBrandNew());
				$productColorLabel = $this->getOptionIdFromLabel('catalog_product', 'color', $product->getColor());
				//Validate the Assigned Brand 
				if($productBrandLabel) {
					$productBrandLabel = $productBrandLabel;
				} else {
					$productBrandLabel = self::NA_FLAG;
				}
				
				//Validate the Assigned Color
				if($productColorLabel) {
					$productColorLabel = $productColorLabel;
				} else {
					$productColorLabel = self::NA_FLAG;
				}
				
				//Validate the Assigned Product Bane
				if($product->getName()) {
					$productName = $product->getName();
				} else {
					$productName = self::NA_FLAG;
				}
				
				//Validate the Assigned Product Price
				if($product->getPrice()) {
					$productPrice = $product->getPrice();
				} else {
					$productPrice = self::NA_FLAG;
				}
				
				//Validate the Assigned Category Name
				if($category->getName()) {
					$categoryName = $category->getName();
				} else {
					$categoryName = self::NA_FLAG;
				}
				$storeCurrency = $this->_storeManager->getStore()->getDefaultCurrencyCode();
				
				$response = array(
					'name'    => $productName,
					'id'      => $productId,
					'price'   => $productPrice,
					'brand'   => $productBrandLabel,
					'category'=> $categoryName,
					'variant' => $productColorLabel,
					'list'=>     'PDP',
					'position'=> 1
				);				
				return $response;
            } catch (NoSuchEntityException $e) {
                $product = null;
            }            
        }        
    }
	
		/**
     * Get Option id from Label
     * @param type $entityType
	 * @param type $entityCode
	 * @param type $arrtibuteName
     * @return string
     */
    public function getOptionIdFromLabel($entityType, $entityCode, $arrtibuteName) {
		if(isset($arrtibuteName)) {
				$attribute = $this->eavConfig->getAttribute($entityType, $entityCode);
				$options = $attribute->getSource()->getAllOptions();
				foreach($options as $option) {
					if($option['value'] == $arrtibuteName) {
						return $option['label'];	
					}				   
				}
		}
    }
}
