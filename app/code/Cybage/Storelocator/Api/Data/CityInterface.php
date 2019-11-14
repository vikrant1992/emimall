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

interface CityInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const CITY_ID = 'city_id';
    const CITY_NAME = 'city_name';
    const BAJAJ_CITY_ID = 'bajaj_city_id';

    /**
     * Get city_id
     * @return string|null
     */
    public function getCityId();

    /**
     * Set city_id
     * @param string $cityId
     * @return \Cybage\Storelocator\Api\Data\CityInterface
     */
    public function setCityId($cityId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\CityExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\CityExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\CityExtensionInterface $extensionAttributes
    );

    /**
     * Get cityName
     * @return string|null
     */
    public function getCityName();

    /**
     * Set cityName
     * @param string $cityName
     * @return \Cybage\Storelocator\Api\Data\CityInterface
     */
    public function setCityName($cityName);

    /**
     * Get bajaj_city_id
     * @return string|null
     */
    public function getBajajCityId();

    /**
     * Set bajaj_city_id
     * @param string $bajajCityId
     * @return \Cybage\Storelocator\Api\Data\CityInterface
     */
    public function setBajajCityId($bajajCityId);
}
