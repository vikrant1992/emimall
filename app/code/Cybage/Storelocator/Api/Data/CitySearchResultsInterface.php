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

interface CitySearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get City list.
     * @return \Cybage\Storelocator\Api\Data\CityInterface[]
     */
    public function getItems();

    /**
     * Set city_id list.
     * @param \Cybage\Storelocator\Api\Data\CityInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
