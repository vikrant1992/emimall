<?php
/**
 * BFL Cybage_ImportReview
 *
 * @category   Cybage_ImportReview
 * @package    BFL Cybage_ImportReview
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\ImportReview\Model\ResourceModel;

class SanitizeReviews extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    /**
     * Reviews Not Approved Status
     */
    const NOT_APPROVED_STATUS = 3;
    
    /**
     * Construct
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param \Psr\Log\LoggerInterface $logger
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        \Psr\Log\LoggerInterface $logger,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->logger = $logger;
        $this->dateTime = $dateTime;
    }
    
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('review', 'review_id');
    }
    
    /**
     * Fetch reviews with duplicate records
     */
    public function execute() {
        $logger = $this->getLoggerInstance();
        $connection = $this->getConnection();
        $mainTable = $this->getTable('review');
        $select = $connection->select()->from(
            ['main'=> $mainTable],
            [
              'review_id' => 'GROUP_CONCAT(rdt.review_id ORDER BY rdt.review_id DESC)',
              'rowhash' => 'MD5(CONCAT(main.created_at,main.entity_pk_value,main.status_id,rdt.title,rdt.detail,rdt.nickname))'
            ]
        )->join(
            ['rdt' => $this->getTable('review_detail')],
            'main.review_id = rdt.review_id'
        )->group(
           'rowhash'
        );
        
        $reviews = $connection->fetchCol($select);
        if ($reviews) {
            $logger->info("Reviews List");
            $logger->info(print_r($reviews,true));
            $this->processReviews($reviews);
        }
        return [];
    }
    
    /**
     * Process Reviews with duplicate records
     * @param array $reviews
     */
    protected function processReviews($reviews) {
        $rowsCount = 0;
        $logger = $this->getLoggerInstance();
        foreach($reviews as $reviewids){
            $review_ids = explode(',', $reviewids);
            $logger->info("Review Ids Before");
            $logger->info(print_r($review_ids,true));
            if(count($review_ids) > 1){
                array_shift($review_ids);
                $logger->info("Review Ids Now");
                $logger->info(print_r($review_ids,true));
                $rowsCount = $this->updateReviewStatus($review_ids);
                $logger->info($rowsCount." Reviews Updated");
            }
        }
    }
    
    /**
     * Update Review Status to Not Approved for duplicate records
     * @param array $reviewIds
     * @return int
     */
    protected function updateReviewStatus($reviewIds) {
        $rowsCount = 0;
        $logger = $this->getLoggerInstance();
        $logger->info("Review Ids to be updated");
        $logger->info(print_r($reviewIds,true));
        if ($reviewIds) {
            $bind = ['status_id' => self::NOT_APPROVED_STATUS];
            $where = ['review_id IN(?)' => $reviewIds];
            $rowsCount = $this->getConnection()->update($this->getTable('review'), $bind, $where);
        }
        return $rowsCount;
    }
    
    /**
     * Get Logger Instance
     * @return \Zend\Log\Logger
     */
    public function getLoggerInstance() {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/duplicate_reviews.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        return $logger;
    }
}
