<?php

/**
 * BFL Attributemapping
 *
 * @category   Attributemapping Module
 * @package    BFL Attributemapping
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Attributemapping\Api\Data;

interface AttributesSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface {

    /**
     * Get Attributes list.
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface[]
     */
    public function getItems();

    /**
     * Set model_code list.
     * @param \Cybage\Attributemapping\Api\Data\AttributesInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
