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

interface DealergroupSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Dealergroup list.
     * @return \Cybage\Storelocator\Api\Data\DealergroupInterface[]
     */
    public function getItems();

    /**
     * Set group_id list.
     * @param \Cybage\Storelocator\Api\Data\DealergroupInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
