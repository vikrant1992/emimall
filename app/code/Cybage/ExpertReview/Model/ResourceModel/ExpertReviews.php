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

namespace Cybage\ExpertReview\Model\ResourceModel;

class ExpertReviews extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    
    /**
     * Define resource model
     *
     * @return void
     */
    public function _construct(){
        $this->_init("cybage_expert_review", "entity_id");
    }
}
