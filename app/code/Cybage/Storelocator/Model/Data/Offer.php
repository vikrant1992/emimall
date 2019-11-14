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

use Cybage\Storelocator\Api\Data\OfferInterface;

class Offer extends \Magento\Framework\Api\AbstractExtensibleObject implements OfferInterface
{

    /**
     * Get offer_id
     * @return string|null
     */
    public function getOfferId()
    {
        return $this->_get(self::OFFER_ID);
    }

    /**
     * Set offer_id
     * @param string $offerId
     * @return \Cybage\Storelocator\Api\Data\OfferInterface
     */
    public function setOfferId($offerId)
    {
        return $this->setData(self::OFFER_ID, $offerId);
    }

    /**
     * Get dealerid
     * @return string|null
     */
    public function getDealerid()
    {
        return $this->_get(self::DEALERID);
    }

    /**
     * Set dealerid
     * @param string $dealerid
     * @return \Cybage\Storelocator\Api\Data\OfferInterface
     */
    public function setDealerid($dealerid)
    {
        return $this->setData(self::DEALERID, $dealerid);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\OfferExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\OfferExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\OfferExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get dealerofferid
     * @return string|null
     */
    public function getDealerofferid()
    {
        return $this->_get(self::DEALEROFFERID);
    }

    /**
     * Set dealerofferid
     * @param string $dealerofferid
     * @return \Cybage\Storelocator\Api\Data\OfferInterface
     */
    public function setDealerofferid($dealerofferid)
    {
        return $this->setData(self::DEALEROFFERID, $dealerofferid);
    }

    /**
     * Get offer_text
     * @return string|null
     */
    public function getOfferText()
    {
        return $this->_get(self::OFFER_TEXT);
    }

    /**
     * Set offer_text
     * @param string $offerText
     * @return \Cybage\Storelocator\Api\Data\OfferInterface
     */
    public function setOfferText($offerText)
    {
        return $this->setData(self::OFFER_TEXT, $offerText);
    }
}
