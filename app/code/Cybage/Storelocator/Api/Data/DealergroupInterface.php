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

namespace Cybage\Storelocator\Api\Data;

interface DealergroupInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const GROUP_ID = 'group_id';
    const DEALERGROUP_ID = 'dealergroup_id';
    const STORE_NAME = 'store_name';

    /**
     * Get dealergroup_id
     * @return string|null
     */
    public function getDealergroupId();

    /**
     * Set dealergroup_id
     * @param string $dealergroupId
     * @return \Cybage\Storelocator\Api\Data\DealergroupInterface
     */
    public function setDealergroupId($dealergroupId);

    /**
     * Get group_id
     * @return string|null
     */
    public function getGroupId();

    /**
     * Set group_id
     * @param string $groupId
     * @return \Cybage\Storelocator\Api\Data\DealergroupInterface
     */
    public function setGroupId($groupId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\DealergroupExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\DealergroupExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\DealergroupExtensionInterface $extensionAttributes
    );

    /**
     * Get store_name
     * @return string|null
     */
    public function getStoreName();

    /**
     * Set store_name
     * @param string $storeName
     * @return \Cybage\Storelocator\Api\Data\DealergroupInterface
     */
    public function setStoreName($storeName);
}
