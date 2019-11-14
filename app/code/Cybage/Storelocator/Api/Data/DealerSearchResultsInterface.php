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

interface DealerSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Dealer list.
     * @return \Cybage\Storelocator\Api\Data\DealerInterface[]
     */
    public function getItems();

    /**
     * Set group_id list.
     * @param \Cybage\Storelocator\Api\Data\DealerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
