<?php
/**
 * BFL Cybage_Productdetail
 *
 * @category   Cybage_Productdetail Helpere
 * @package    BFL Cybage_Productdetail
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Productdetail\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Data
 */
class Data extends AbstractHelper
{
    /**
     * Youtube Embed url
     */
    const YOUTUBE_EMBED_URL = 'https://www.youtube.com/embed/';

    /**
     * Youtube API url
     */
    const YOUTUBE_API_PARAMS = '?enablejsapi=1&rel=0';

    /**
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Review\Model\ReviewFactory $reviewFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Cybage\ExpertReview\Model\ResourceModel\ExpertReviews\CollectionFactory $expertReviewFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Cybage\ExpertReview\Model\ResourceModel\ExpertReviews\CollectionFactory $expertReviewFactory
    ) {

        parent::__construct($context);
        $this->registry = $registry;
        $this->_reviewFactory = $reviewFactory;
        $this->_storeManager = $storeManager;
        $this->_expertReviewFactory = $expertReviewFactory;
    }

    /**
     * getRatingSummary
     * @return type
     */
    public function getRatingSummary($product)
    {
        $this->_reviewFactory->create()->getEntitySummary($product, $this->_storeManager->getStore()->getId());
        $data['reviews_type'] = 'User Reviews';
        $data['reviews_count'] = $product->getRatingSummary()->getReviewsCount();
        $data['rating_percent'] = $product->getRatingSummary()->getRatingSummary();
        $productSku = $product->getSku();
        $expertReview = $this->_expertReviewFactory->create()
            ->addFieldToFilter('sku', $productSku)
            ->setPageSize(1)
            ->getFirstItem();
        $expertReviewData = null;
        if ($expertReview->getId() && ($expertReview['rating'] > 0)) {
            $data['reviews_type'] = 'Expert Review';
            $data['reviews_count'] = 1;
            $data['rating_percent'] = (100 * $expertReview['rating'])/5;
        }
        return $data;
    }
    
    /**
     * getYoutubeEmbedUrl
     * @param type $url
     * @return type String
     */
    public function getYoutubeEmbedUrl($url)
    {
        $urlParts = explode('/', $url);
        $vidid = explode('&', str_replace('watch?v=', '', end($urlParts)));
        return self::YOUTUBE_EMBED_URL . $vidid[0].self::YOUTUBE_API_PARAMS ;
    }
}
