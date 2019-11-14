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

use Cybage\Storelocator\Api\Data\DealercategoryInterface;

class Dealercategory extends \Magento\Framework\Api\AbstractExtensibleObject implements DealercategoryInterface
{

    /**
     * Get dealercategory_id
     * @return string|null
     */
    public function getDealercategoryId()
    {
        return $this->_get(self::DEALERCATEGORY_ID);
    }

    /**
     * Set dealercategory_id
     * @param string $dealercategoryId
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     */
    public function setDealercategoryId($dealercategoryId)
    {
        return $this->setData(self::DEALERCATEGORY_ID, $dealercategoryId);
    }

    /**
     * Get dealer_id
     * @return string|null
     */
    public function getDealerId()
    {
        return $this->_get(self::DEALER_ID);
    }

    /**
     * Set dealer_id
     * @param string $dealerId
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     */
    public function setDealerId($dealerId)
    {
        return $this->setData(self::DEALER_ID, $dealerId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\DealercategoryExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\DealercategoryExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\DealercategoryExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get oem_id
     * @return string|null
     */
    public function getOemId()
    {
        return $this->_get(self::OEM_ID);
    }

    /**
     * Set oem_id
     * @param string $oemId
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     */
    public function setOemId($oemId)
    {
        return $this->setData(self::OEM_ID, $oemId);
    }

    /**
     * Get oem_name
     * @return string|null
     */
    public function getOemName()
    {
        return $this->_get(self::OEM_NAME);
    }

    /**
     * Set oem_name
     * @param string $oemName
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     */
    public function setOemName($oemName)
    {
        return $this->setData(self::OEM_NAME, $oemName);
    }

    /**
     * Get subcategory_id
     * @return string|null
     */
    public function getSubcategoryId()
    {
        return $this->_get(self::SUBCATEGORY_ID);
    }

    /**
     * Set subcategory_id
     * @param string $subcategoryId
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     */
    public function setSubcategoryId($subcategoryId)
    {
        return $this->setData(self::SUBCATEGORY_ID, $subcategoryId);
    }
}
