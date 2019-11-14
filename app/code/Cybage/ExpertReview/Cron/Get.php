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

namespace Cybage\ExpertReview\Cron;

class Get
{
        /**
     * @var \Cybage\ExpertReview\Helper\Data
     */
    protected $_data;

    /**
     *
     * @param \Cybage\ExpertReview\Helper\Data $data
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Catalog\Model\CategoryRepository $categoryRepository
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product $productResourceModel
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Cybage\ExpertReview\Model\ResourceModel\ExpertReviews\CollectionFactory $expertReviewFactory
     */
    public function __construct(
        \Cybage\ExpertReview\Helper\Data $data,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product $productResourceModel,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Psr\Log\LoggerInterface $customLogger,
        \Cybage\ExpertReview\Model\ResourceModel\ExpertReviews\CollectionFactory $expertReviewFactory
    ) {
        $this->_data = $data;
        $this->_jsonHelper = $jsonHelper;
        $this->_productResourceModel = $productResourceModel;
        $this->_productFactory = $productFactory;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryRepository = $categoryRepository;
        $this->_expertReviewFactory = $expertReviewFactory;
        $this->_logger = $customLogger;
    }

    /**
     * Execute
     * @return \Cybage\ExpertReview\Cron\Get
     */
    public function execute()
    {
        $categories = $this->get91mobilesCategories();
        if (isset($categories) && !empty($categories)) {
            $response = true;
            foreach ($categories as $category) {
                $pageNo = 0;
                $response = $this->_data->getExpertReview($category, null, $pageNo);
            }
            if ($response) {
                $this->bulkUpdateProducts();
            }
        }
    }

    /**
     * bulkUpdateProducts
     */
    public function bulkUpdateProducts()
    {
        $expertReviews = $this->_expertReviewFactory->create()
                ->addFieldToFilter('spec_score', ['neq' => 'NULL']);
        foreach ($expertReviews as $expertReview) {
            $specScore = 0;
            $keySpecScore = $this->_jsonHelper->jsonDecode($expertReview['spec_score']);
            if ((isset($keySpecScore['overall_score']) && (isset($expertReview['sku']) && trim($expertReview['sku']) !== ''))) {
                $specScore = $keySpecScore['overall_score'];
                $sku = $expertReview['sku'];
                $this->updateProductSpecScore($sku, $specScore);
            }
        }
    }
    /**
     * get91mobilesCategories
     * get91mobilesCategories
     * @return type
     */
    public function get91mobilesCategories()
    {
        $expertReviewsCategories = [];
        $collection = $this->_categoryCollectionFactory->create()
            ->addAttributeToSelect('91mobiles_category_id');
        foreach ($collection as $category) {
            $category->getEntityId();
            $categoryData = $this->_categoryRepository->get($category->getEntityId())->getData('91mobiles_category_id');
            if (isset($categoryData) && !empty($categoryData)) {
                $expertReviewsCategories[] = $categoryData;
            }
        }
        return $expertReviewsCategories;
    }

    /**
     * updateProductSpecScore
     * @param type $sku
     * @param type $specScore
     */
    public function updateProductSpecScore($sku, $specScore)
    {
        $product = $this->_productFactory->create();
        $product->load($product->getIdBySku($sku));
        if ($product->getEntityId()) {
            $this->_logger->info('Update product '.$product->getEntityId(). ' '.$specScore);
            $product->setSpecScore($specScore);
            $this->_productResourceModel->saveAttribute($product, 'spec_score');
        }
    }
}
