<?php

/**
 * BFL Storelocator
 *
 * @category   Storelocator Module
 * @package    BFL Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Model\Data;

use Cybage\Storelocator\Api\Data\DealergroupInterface;

class Dealergroup extends \Magento\Framework\Api\AbstractExtensibleObject implements DealergroupInterface
{

    /**
     * Get dealergroup_id
     * @return string|null
     */
    public function getDealergroupId()
    {
        return $this->_get(self::DEALERGROUP_ID);
    }

    /**
     * Set dealergroup_id
     * @param string $dealergroupId
     * @return \Cybage\Storelocator\Api\Data\DealergroupInterface
     */
    public function setDealergroupId($dealergroupId)
    {
        return $this->setData(self::DEALERGROUP_ID, $dealergroupId);
    }

    /**
     * Get group_id
     * @return string|null
     */
    public function getGroupId()
    {
        return $this->_get(self::GROUP_ID);
    }

    /**
     * Set group_id
     * @param string $groupId
     * @return \Cybage\Storelocator\Api\Data\DealergroupInterface
     */
    public function setGroupId($groupId)
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\DealergroupExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\DealergroupExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\DealergroupExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get store_name
     * @return string|null
     */
    public function getStoreName()
    {
        return $this->_get(self::STORE_NAME);
    }

    /**
     * Set store_name
     * @param string $storeName
     * @return \Cybage\Storelocator\Api\Data\DealergroupInterface
     */
    public function setStoreName($storeName)
    {
        return $this->setData(self::STORE_NAME, $storeName);
    }
}
