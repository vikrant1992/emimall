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

interface OfferSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Offer list.
     * @return \Cybage\Storelocator\Api\Data\OfferInterface[]
     */
    public function getItems();

    /**
     * Set dealerid list.
     * @param \Cybage\Storelocator\Api\Data\OfferInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
