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
 * Class Reviews
 */
class Reviews extends \Magento\Framework\View\Element\Template
{
    const MAX_STAR_COUNT = 5;
    protected $productRepository;
    protected $_reviewCollection;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewCollection
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Review\Model\Review $ratingFactory
     * @param \Magento\Review\Model\ReviewFactory $reviewFactory
     * @param \Cybage\ExpertReview\Model\ResourceModel\ExpertReviews\CollectionFactory $expertReviewFactory
     * @param \Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection $votes
     * @param \Magento\Review\Model\RatingFactory $starRatingFactory
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewCollection,
        \Magento\Framework\Registry $registry,
        \Magento\Review\Model\Review $ratingFactory,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Cybage\ExpertReview\Model\ResourceModel\ExpertReviews\CollectionFactory $expertReviewFactory,
        \Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection $votes,
        \Magento\Review\Model\RatingFactory $starRatingFactory,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->productRepository = $productRepository;
        $this->_reviewCollection = $reviewCollection;
        $this->registry = $registry;
        $this->_ratingFactory = $ratingFactory;
        $this->_reviewFactory = $reviewFactory;
        $this->_expertReviewFactory = $expertReviewFactory;
        $this->votes = $votes;
        $this->_jsonHelper = $jsonHelper;
        $this->_starratingFactory = $starRatingFactory;
        $this->resource = $resourceConnection;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * Get current product ID
     * @return int
     */
    public function getProductId()
    {
        $currentProduct = $this->registry->registry('current_product');
        $productId = $currentProduct->getId();
        return $productId;
    }

    /**
     *
     * @return type
     */
    public function getProductSpecScore()
    {
        $currentProduct = $this->registry->registry('current_product');
        return number_format($currentProduct->getSpecScore(), 0);
    }

    /**
     * getSpecGroup
     * @return type array
     */
    public function getSpecGroup()
    {
        $currentProduct = $this->registry->registry('current_product');
        $productSku = $currentProduct->getSku();
        
        $expertReview = $this->_expertReviewFactory->create()
                    ->addFieldToFilter('sku', $productSku)
                    ->setPageSize(1)
                    ->getFirstItem();
        $keySpec = null;
        if ($expertReview->getId()) {
            $keySpec = $this->_jsonHelper->jsonDecode($expertReview['spec_score']);
            unset($keySpec['overall_score']);
        }
        return $keySpec;
    }

    /**
     * getProduct
     * @return type
     */
    public function getProduct()
    {
        $currentProduct = $this->registry->registry('current_product');
        return $currentProduct;
    }
    /**
     * Get expert review for product
     * @return array|null
     */
    public function getExpertReview()
    {
        $currentProduct = $this->registry->registry('current_product');
        $productSku = $currentProduct->getSku();
        
        $expertReview = $this->_expertReviewFactory->create()
                    ->addFieldToFilter('sku', $productSku)
                    ->setPageSize(1)
                    ->getFirstItem();
        $expertReviewData = null;
        if ($expertReview->getId()) {
            $expertReviewData['rating'] = number_format($expertReview['rating'], 2);
            $expertReviewData['title'] = $expertReview['title'];
            $expertReviewData['reviewed_date'] = date('M d Y', strtotime($expertReview['reviewed_date']));
            $expertReviewData['reviewed_by'] = $expertReview['reviewed_by'];
            $expertReviewData['verdict'] = $expertReview['verdict'];
            if ($expertReview['pros'] != null) {
                $expertReviewData['pros'] = $this->_jsonHelper->jsonDecode($expertReview['pros']);
            }
            if ($expertReview['cons'] != null) {
                $expertReviewData['cons'] = $this->_jsonHelper->jsonDecode($expertReview['cons']);
            }
            if ($expertReview['videos'] != null) {
                $expertReviewData['videos'] = $this->_jsonHelper->jsonDecode($expertReview['videos']);
            }
        }
        return $expertReviewData;
    }

    /**
     * Get user ratings
     * @return array
     */
    public function getUserRatings()
    {
        $review = $this->_ratingFactory->getCollection()
                ->addFieldToFilter('main_table.status_id', 1)
                ->addEntityFilter('product', $this->getProductId())
                ->addStoreFilter(1);
        $review->getSelect()->columns('detail.detail_id')->joinInner(
            ['vote' => $review->getTable('rating_option_vote')],
            'main_table.review_id = vote.review_id',
            ['review_value' => 'vote.value']
        );
        $review->getSelect()->order('review_value DESC');
        $review->getSelect()->columns('count(vote.vote_id) as total_vote')->group('review_value');
        for ($i = self::MAX_STAR_COUNT; $i >= 1; $i--) {
            $arrRatings[$i]['value'] = 0;
        }
        $arrRatings = [];
        foreach ($review as $_result) {
            $arrRatings[$_result['review_value']]['value'] = $_result['total_vote'];
        }
        for ($stars = 1; $stars <= self::MAX_STAR_COUNT; $stars++) {
            if (!isset($arrRatings[$stars])) {
                $arrRatings[$stars] = ['value' => 0];
            }
        }
        return $arrRatings;
    }

    /**
     * Get user reviews
     * @return array
     */
    public function getAllreviews()
    {
        $collection = $this->_reviewCollection->create()
                        ->addStatusFilter(
                            \Magento\Review\Model\Review::STATUS_APPROVED
                        )->addEntityFilter(
                            'product',
                            $this->getProductId()
                        )->setDateOrder()->getData();

        foreach ($collection as $key => $review) {
            $collection[$key]['stars'] = $this->getStarsCount($review['review_id']);
        }

        return $collection;
    }

    /**
     * Get ratings data
     * @return array
     */
    public function getRatingSummary()
    {
        $product = $this->registry->registry('current_product');
        $this->_reviewFactory->create()->getEntitySummary($product, $this->_storeManager->getStore()->getId());
        $ratingSummary = $product->getRatingSummary()->getRatingSummary();
        return $ratingSummary;
    }
    
    /**
     * Get star count
     * @return array
     */
    public function getStarsCount($reviewId)
    {
        if (!empty($reviewId)) {
            $connection = $this->resource->getConnection();
            $tableName = $this->resource->getTableName('rating_option_vote');
            $sql = $connection->select('value')
                    ->from($tableName)
                    ->where('review_id = ?', $reviewId);
            $result = $connection->fetchAll($sql);
            if (isset($result[0]['value'])) {
                return $result[0]['value'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * isLoggedIn
     * @return type boolean
     */
    public function isLoggedIn()
    {
        if ($this->customerSession->isLoggedIn()) {
            return true;
        } else {
            return false;
        }
    }
}
