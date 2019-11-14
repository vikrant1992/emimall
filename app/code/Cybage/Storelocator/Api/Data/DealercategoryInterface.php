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

interface DealercategoryInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const OEM_NAME = 'oem_name';
    const DEALERCATEGORY_ID = 'dealercategory_id';
    const OEM_ID = 'oem_id';
    const SUBCATEGORY_ID = 'subcategory_id';
    const DEALER_ID = 'dealer_id';

    /**
     * Get dealercategory_id
     * @return string|null
     */
    public function getDealercategoryId();

    /**
     * Set dealercategory_id
     * @param string $dealercategoryId
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     */
    public function setDealercategoryId($dealercategoryId);

    /**
     * Get dealer_id
     * @return string|null
     */
    public function getDealerId();

    /**
     * Set dealer_id
     * @param string $dealerId
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     */
    public function setDealerId($dealerId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\DealercategoryExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\DealercategoryExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\DealercategoryExtensionInterface $extensionAttributes
    );

    /**
     * Get oem_id
     * @return string|null
     */
    public function getOemId();

    /**
     * Set oem_id
     * @param string $oemId
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     */
    public function setOemId($oemId);

    /**
     * Get oem_name
     * @return string|null
     */
    public function getOemName();

    /**
     * Set oem_name
     * @param string $oemName
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     */
    public function setOemName($oemName);

    /**
     * Get subcategory_id
     * @return string|null
     */
    public function getSubcategoryId();

    /**
     * Set subcategory_id
     * @param string $subcategoryId
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     */
    public function setSubcategoryId($subcategoryId);
}
