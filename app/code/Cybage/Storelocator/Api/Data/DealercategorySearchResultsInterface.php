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

interface DealercategorySearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Dealercategory list.
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface[]
     */
    public function getItems();

    /**
     * Set dealer_id list.
     * @param \Cybage\Storelocator\Api\Data\DealercategoryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
