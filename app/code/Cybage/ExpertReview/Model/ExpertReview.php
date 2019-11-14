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

namespace Cybage\ExpertReview\Model;

class ExpertReview extends \Magento\Framework\Model\AbstractModel{
    
    public function _construct(){
        $this->_init("Cybage\ExpertReview\Model\ResourceModel\ExpertReviews");
    }
}
