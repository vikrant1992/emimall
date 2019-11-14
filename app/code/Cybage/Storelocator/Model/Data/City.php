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

use Cybage\Storelocator\Api\Data\CityInterface;

class City extends \Magento\Framework\Api\AbstractExtensibleObject implements CityInterface
{

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
     * @return \Cybage\Storelocator\Api\Data\CityInterface
     */
    public function setCityId($cityId)
    {
        return $this->setData(self::CITY_ID, $cityId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\CityExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\CityExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\CityExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get BAJAJ_CITY_ID
     * @return string|null
     */
    public function getBajajCityId()
    {
        return $this->_get(self::BAJAJ_CITY_ID);
    }

    /**
     * Get CITY_NAME
     * @return string|null
     */
    public function getCityName()
    {
        return $this->_get(self::CITY_NAME);
    }

    /**
     * Set bajajCityId
     * @param string $bajajCityId
     * @return \Cybage\Storelocator\Api\Data\CityInterface
     */
    public function setBajajCityId($bajajCityId): CityInterface
    {
        return $this->setData(self::BAJAJ_CITY_ID, $bajajCityId);
    }

    /**
     * Set cityName
     * @param string $cityName
     * @return \Cybage\Storelocator\Api\Data\CityInterface
     */
    public function setCityName($cityName): CityInterface
    {
        return $this->setData(self::CITY_NAME, $cityName);
    }
}
