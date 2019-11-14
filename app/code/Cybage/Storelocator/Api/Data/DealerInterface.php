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

interface DealerInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const GROUP_ID = 'group_id';
    const ADDRESS = 'address';
    const AREA = 'area';
    const LONGITUDE = 'longitude';
    const LATITUDE = 'latitude';
    const DEALER_ID = 'dealer_id';
    const DEALER_NAME = 'dealer_name';
    const CITY_ID = 'city_id';
    const BAJAJ_DEALERID = 'bajaj_dealerid';
    const PINCODE = 'pincode';
    const IS_ACTIVE = 'is_active';
    const PHONE = 'phone';
    const SUBCATEGORIES = 'subcategories';
    const HEXA = 'hexacode';
    const SFDC = 'sfdc';

    /**
     * Get dealer_id
     * @return string|null
     */
    public function getDealerId();

    /**
     * Set dealer_id
     * @param string $dealerId
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setDealerId($dealerId);

    /**
     * Get group_id
     * @return string|null
     */
    public function getGroupId();

    /**
     * Set group_id
     * @param string $groupId
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setGroupId($groupId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\DealerExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\DealerExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\DealerExtensionInterface $extensionAttributes
    );

    /**
     * Get address
     * @return string|null
     */
    public function getAddress();

    /**
     * Set address
     * @param string $address
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setAddress($address);

    /**
     * Get city_id
     * @return string|null
     */
    public function getCityId();

    /**
     * Set city_id
     * @param string $cityId
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setCityId($cityId);

    /**
     * Get phone
     * @return string|null
     */
    public function getPhone();

    /**
     * Set phone
     * @param string $phone
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setPhone($phone);

    /**
     * Get bajaj_dealerid
     * @return string|null
     */
    public function getBajajDealerid();

    /**
     * Set bajaj_dealerid
     * @param string $dealerid
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setBajajDealerid($dealerid);

    /**
     * Get dealer_name
     * @return string|null
     */
    public function getDealerName();

    /**
     * Set dealer_name
     * @param string $dealerName
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setDealerName($dealerName);

    /**
     * Get area
     * @return string|null
     */
    public function getArea();

    /**
     * Set area
     * @param string $area
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setArea($area);

    /**
     * Get pincode
     * @return string|null
     */
    public function getPincode();

    /**
     * Set pincode
     * @param string $pincode
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setPincode($pincode);

    /**
     * Get latitude
     * @return string|null
     */
    public function getLatitude();

    /**
     * Set latitude
     * @param string $latitude
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setLatitude($latitude);

    /**
     * Get longitude
     * @return string|null
     */
    public function getLongitude();

    /**
     * Set longitude
     * @param string $longitude
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setLongitude($longitude);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param string $isActive
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setIsActive($isActive);

    /**
     * Get subcategories
     * @return string|null
     */
    public function getSubcategories();

    /**
     * Set is_active
     * @param string $subcategories
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setSubcategories($subcategories);
    
    /**
     * Get Hexa code
     * @return string|null
     */
    public function getHexacode();

    /**
     * Set Hexa code
     * @param string $hexacode
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setHexacode($hexacode);
    
    /**
     * Get SFDC code
     * @return string|null
     */
    public function getSfdc();

    /**
     * Set SFDC code
     * @param string $sfdc
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     */
    public function setSfdc($sfdc);
}
