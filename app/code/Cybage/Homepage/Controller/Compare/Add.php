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

namespace Cybage\Homepage\Controller\Compare;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Model\ResourceModel\Product\Compare\Item\CollectionFactory as ItemCollectionFactory;

class Add extends \Magento\Framework\App\Action\Action
{
    const MAX_COUNT = '3';
    
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    
    /**
     * Item collection factory
     *
     * @var ItemCollectionFactory
     */
    protected $_itemCollectionFactory;
    
    /**
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Visitor $customerVisitor
     * @param \Magento\Catalog\Model\Product\Compare\ListCompare $catalogProductCompareList
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Validator $formKeyValidator
     * @param PageFactory $resultPageFactory
     * @param ProductRepositoryInterface $productRepository
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
        ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Helper\Product\Compare $compareHelper,
        ItemCollectionFactory $itemCollectionFactory
    ) {
        $this->compareHelper = $compareHelper;
        $this->_storeManager = $storeManager;
        $this->_customerSession = $customerSession;
        $this->_customerVisitor = $customerVisitor;
        $this->_catalogProductCompareList = $catalogProductCompareList;
        $this->_formKeyValidator = $formKeyValidator;
        $this->resultPageFactory = $resultPageFactory;
        $this->productRepository = $productRepository;
        $this->_itemCollectionFactory = $itemCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $errorFlag = false;
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $result = [];
        $firstProductSku = $this->getRequest()->getParam('sku1');
        $secondProductSku = $this->getRequest()->getParam('sku2');
        $clearExistingProducts = $this->getRequest()->getParam('removeExisting');
        if($clearExistingProducts){
            $this->clearComparisonList();
        }
        if($firstProductSku && $secondProductSku){
            $firstProduct = $this->productRepository->get($firstProductSku);
            $result = $this->addProduct($firstProduct->getId());
            $secondProduct = $this->productRepository->get($secondProductSku);
            $result = $this->addProduct($secondProduct->getId());
        }
        $resultJson->setData($result);
        return $resultJson;
    }
    
    /**
     * Add Product to Compare
     * @param int $productId
     * @return object
     */
    public function addProduct($productId)
    {
        $errorFlag = false;
        if ($productId && ($this->_customerVisitor->getId() || $this->_customerSession->isLoggedIn())) {
            $storeId = $this->_storeManager->getStore()->getId();
            try {
                $product = $this->productRepository->getById($productId, false, $storeId);
            } catch (NoSuchEntityException $e) {
                $product = null;
            }
            
            if ($product) {
                $collection = $this->compareHelper->getItemCollection();
                
                if ($collection) {
                    if ($collection->getSize() >= self::MAX_COUNT) {
                        $errorFlag = true;
                        $result = [
                            'success' => false,
                            'error_reason' => 'max_products',
                            'message' => __('You have already added maximum number of products')
                        ];
                    } else {
                        foreach ($collection as $compareProduct) {
                            if ($compareProduct->getId() != $product->getId()) {
                                if ($compareProduct->getAttributeSetId() != $product->getAttributeSetId()) {
                                    $errorFlag = true;
                                    $result = [
                                        'success' => false,
                                        'error_reason' => 'different_product',
                                        'message' => __('You can compare product only from same category')
                                    ];
                                    break;
                                }
                            } else {
                                $errorFlag = true;
                                $result = [
                                    'success' => false,
                                    'error_reason' => 'already_product',
                                ];
                            }
                        }
                    }
                }
                if (!$errorFlag) {
                    $this->_catalogProductCompareList->addProduct($product);
                    $this->_eventManager->dispatch('catalog_product_compare_add_product', ['product' => $product]);
                    $result = [
                        'success' => true,
                        'message' => __('Successfully added'),
                        'redirectUrl' => $this->_url->getUrl('catalog/product_compare/index')
                    ];
                }
            }
            $this->_objectManager->get(\Magento\Catalog\Helper\Product\Compare::class)->calculate();
        }
        return $result;
    }
    
    /**
     * Clear Comparison List
     */
    public function clearComparisonList() {
        $customerId = $this->_customerSession->getCustomer()->getId();
        $items = $this->_itemCollectionFactory->create();
        if ($this->_customerSession->isLoggedIn()) {
            $items->setCustomerId($this->_customerSession->getCustomerId());
        } elseif ($customerId) {
            $items->setCustomerId($customerId);
        } else {
            $items->setVisitorId($this->_customerVisitor->getId());
        }
        $items->clear();
        $this->_objectManager->get(\Magento\Catalog\Helper\Product\Compare::class)->calculate();
    }
}
