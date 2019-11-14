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

interface OfferInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const OFFER_TEXT = 'offer_text';
    const DEALEROFFERID = 'dealerofferid';
    const OFFER_ID = 'offer_id';
    const DEALERID = 'dealerid';

    /**
     * Get offer_id
     * @return string|null
     */
    public function getOfferId();

    /**
     * Set offer_id
     * @param string $offerId
     * @return \Cybage\Storelocator\Api\Data\OfferInterface
     */
    public function setOfferId($offerId);

    /**
     * Get dealerid
     * @return string|null
     */
    public function getDealerid();

    /**
     * Set dealerid
     * @param string $dealerid
     * @return \Cybage\Storelocator\Api\Data\OfferInterface
     */
    public function setDealerid($dealerid);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Storelocator\Api\Data\OfferExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Cybage\Storelocator\Api\Data\OfferExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cybage\Storelocator\Api\Data\OfferExtensionInterface $extensionAttributes
    );

    /**
     * Get dealerofferid
     * @return string|null
     */
    public function getDealerofferid();

    /**
     * Set dealerofferid
     * @param string $dealerofferid
     * @return \Cybage\Storelocator\Api\Data\OfferInterface
     */
    public function setDealerofferid($dealerofferid);

    /**
     * Get offer_text
     * @return string|null
     */
    public function getOfferText();

    /**
     * Set offer_text
     * @param string $offerText
     * @return \Cybage\Storelocator\Api\Data\OfferInterface
     */
    public function setOfferText($offerText);
}
