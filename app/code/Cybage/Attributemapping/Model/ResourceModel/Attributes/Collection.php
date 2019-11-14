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

namespace Cybage\Attributemapping\Model\ResourceModel\Attributes;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
        $this->_init(
                \Cybage\Attributemapping\Model\Attributes::class, \Cybage\Attributemapping\Model\ResourceModel\Attributes::class
        );
    }

}
