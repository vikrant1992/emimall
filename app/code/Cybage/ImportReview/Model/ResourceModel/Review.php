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

use Magento\Framework\Model\AbstractModel;

class Review extends \Magento\Review\Model\ResourceModel\Review
{
    /**
     * Perform actions before object save
     *
     * @param AbstractModel $object
     * @return $this
     */
    protected function _beforeSave(AbstractModel $object)
    {
        if (!$object->getId()) {
            $object->setCreatedAt($object->getCreatedAt());
        }
        if ($object->hasData('stores') && is_array($object->getStores())) {
            $stores = $object->getStores();
            $stores[] = 0;
            $object->setStores($stores);
        } elseif ($object->hasData('stores')) {
            $object->setStores([$object->getStores(), 0]);
        }
        return $this;
    }
}
