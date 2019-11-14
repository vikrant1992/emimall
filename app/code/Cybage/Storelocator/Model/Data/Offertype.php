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

namespace Cybage\Storelocator\Model\Data;

use Cybage\Storelocator\Api\Data\OffertypeInterface;

class Offertype extends \Magento\Framework\Api\AbstractExtensibleObject implements OffertypeInterface
{

    /**
     * Get offertype_id
     * @return string|null
     */
    public function getOffertypeId()
    {
        return $this->_get(self::OFFERTYPE_ID);
    }

    /**
     * Set offertype_id
     * @param string $offertypeId
     * @return \Cybage\Storelocator\Api\Data\OffertypeInterface
     */
    public function setOffertypeId($offertypeId)
    {
        return $this->setData(self::OFFERTYPE_ID, $offertypeId);
    }

    /**
     * Get offerid
     * @return string|null
     */
    public function getOfferid()
    {
        return $this->_get(self::OFFERID);
    }

    /**
     * Set offerid
     * @param string $offerid
     * @return \Cybage\Storelocator\Api\Data\OffertypeInterface
     */
    public function setOfferid($offerid)
    {
        return $this->setData(self::OFFERID, $offerid);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\OffertypeExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\OffertypeExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\OffertypeExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get offer_type
     * @return string|null
     */
    public function getOfferType()
    {
        return $this->_get(self::OFFER_TYPE);
    }

    /**
     * Set offer_type
     * @param string $offerType
     * @return \Cybage\Storelocator\Api\Data\OffertypeInterface
     */
    public function setOfferType($offerType)
    {
        return $this->setData(self::OFFER_TYPE, $offerType);
    }
}
