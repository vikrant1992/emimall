<?php

/**
 * BFL Cybage_Storelocator
 *
 * @category   Cybage_Storelocator
 * @package    BFL Cybage_Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Api\Data;

interface OffertypeInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const OFFERID = 'offerid';
    const OFFER_TYPE = 'offer_type';
    const OFFERTYPE_ID = 'offertype_id';

    /**
     * Get offertype_id
     * @return string|null
     */
    public function getOffertypeId();

    /**
     * Set offertype_id
     * @param string $offertypeId
     * @return \Cybage\Storelocator\Api\Data\OffertypeInterface
     */
    public function setOffertypeId($offertypeId);

    /**
     * Get offerid
     * @return string|null
     */
    public function getOfferid();

    /**
     * Set offerid
     * @param string $offerid
     * @return \Cybage\Storelocator\Api\Data\OffertypeInterface
     */
    public function setOfferid($offerid);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\OffertypeExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\OffertypeExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\OffertypeExtensionInterface $extensionAttributes
    );

    /**
     * Get offer_type
     * @return string|null
     */
    public function getOfferType();

    /**
     * Set offer_type
     * @param string $offerType
     * @return \Cybage\Storelocator\Api\Data\OffertypeInterface
     */
    public function setOfferType($offerType);
}
