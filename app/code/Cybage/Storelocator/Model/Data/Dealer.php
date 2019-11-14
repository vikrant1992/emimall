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

use Cybage\Storelocator\Api\Data\DealerInterface;

class Dealer extends \Magento\Framework\Api\AbstractExtensibleObject implements DealerInterface
{

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
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setDealerId($dealerId)
    {
        return $this->setData(self::DEALER_ID, $dealerId);
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
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setGroupId($groupId)
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\DealerExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\DealerExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\DealerExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get address
     * @return string|null
     */
    public function getAddress()
    {
        return $this->_get(self::ADDRESS);
    }

    /**
     * Set address
     * @param string $address
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Get city_id
     * @return string|null
     */
    public function getCityId()
    {
        return $this->_get(self::CITY_ID);
    }

    /**
     * Set city_id
     * @param string $cityId
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setCityId($cityId)
    {
        return $this->setData(self::CITY_ID, $cityId);
    }

    /**
     * Get phone
     * @return string|null
     */
    public function getPhone()
    {
        return $this->_get(self::PHONE);
    }

    /**
     * Set phone
     * @param string $phone
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setPhone($phone)
    {
        return $this->setData(self::PHONE, $phone);
    }

    /**
     * Get bajaj_dealerid
     * @return string|null
     */
    public function getBajajDealerid()
    {
        return $this->_get(self::BAJAJ_DEALERID);
    }

    /**
     * Set bajaj_dealerid
     * @param string $dealerid
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setBajajDealerid($dealerid)
    {
        return $this->setData(self::BAJAJ_DEALERID, $dealerid);
    }

    /**
     * Get dealer_name
     * @return string|null
     */
    public function getDealerName()
    {
        return $this->_get(self::DEALER_NAME);
    }

    /**
     * Set dealer_name
     * @param string $dealerName
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setDealerName($dealerName)
    {
        return $this->setData(self::DEALER_NAME, $dealerName);
    }

    /**
     * Get area
     * @return string|null
     */
    public function getArea()
    {
        return $this->_get(self::AREA);
    }

    /**
     * Set area
     * @param string $area
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setArea($area)
    {
        return $this->setData(self::AREA, $area);
    }

    /**
     * Get pincode
     * @return string|null
     */
    public function getPincode()
    {
        return $this->_get(self::PINCODE);
    }

    /**
     * Set pincode
     * @param string $pincode
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setPincode($pincode)
    {
        return $this->setData(self::PINCODE, $pincode);
    }

    /**
     * Get latitude
     * @return string|null
     */
    public function getLatitude()
    {
        return $this->_get(self::LATITUDE);
    }

    /**
     * Set latitude
     * @param string $latitude
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setLatitude($latitude)
    {
        return $this->setData(self::LATITUDE, $latitude);
    }

    /**
     * Get longitude
     * @return string|null
     */
    public function getLongitude()
    {
        return $this->_get(self::LONGITUDE);
    }

    /**
     * Set longitude
     * @param string $longitude
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setLongitude($longitude)
    {
        return $this->setData(self::LONGITUDE, $longitude);
    }

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive()
    {
        return $this->_get(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     * @param string $isActive
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Set subcategories
     * @param string $subcategories
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setSubcategories($subcategories)
    {
        return $this->setData(self::SUBCATEGORIES, $subcategories);
    }

    /**
     * Get subcategories
     * @return string|null
     */
    public function getSubcategories()
    {
        return $this->_get(self::SUBCATEGORIES);
    }
    
    /**
     * Set Hexacode
     * @param string $hexacode
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setHexacode($hexacode)
    {
        return $this->setData(self::HEXA, $hexacode);
    }

    /**
     * Get Hexacode
     * @return string|null
     */
    public function getHexacode()
    {
        return $this->_get(self::HEXA);
    }
    
    /**
     * Set sfdc
     * @param string $sfdc
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setSfdc($sfdc)
    {
        return $this->setData(self::SFDC, $sfdc);
    }

    /**
     * Get sfdc
     * @return string|null
     */
    public function getSfdc()
    {
        return $this->_get(self::SFDC);
    }
}
