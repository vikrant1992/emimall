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

interface OffertypeSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Offertype list.
     * @return \Cybage\Storelocator\Api\Data\OffertypeInterface[]
     */
    public function getItems();

    /**
     * Set offerid list.
     * @param \Cybage\Storelocator\Api\Data\OffertypeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
