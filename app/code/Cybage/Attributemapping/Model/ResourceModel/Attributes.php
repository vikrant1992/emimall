<?php

/**
 * BFL Attributemapping
 *
 * @category   Attributemapping Module
 * @package    BFL Attributemapping
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Attributemapping\Model\ResourceModel;

class Attributes extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
        $this->_init('cybage_attributemapping_attributes', 'attributes_id');
    }

}
