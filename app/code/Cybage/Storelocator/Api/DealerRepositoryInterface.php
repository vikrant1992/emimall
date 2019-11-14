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

namespace Cybage\Storelocator\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface DealerRepositoryInterface
{

    /**
     * Save Dealer
     * @param \Cybage\Storelocator\Api\Data\DealerInterface $dealer
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Cybage\Storelocator\Api\Data\DealerInterface $dealer
    );

    /**
     * Retrieve Dealer
     * @param string $dealerId
     * @return \Cybage\Storelocator\Api\Data\DealerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($dealerId);

    /**
     * Retrieve Dealer matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Cybage\Storelocator\Api\Data\DealerSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Dealer
     * @param \Cybage\Storelocator\Api\Data\DealerInterface $dealer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Cybage\Storelocator\Api\Data\DealerInterface $dealer
    );

    /**
     * Delete Dealer by ID
     * @param string $dealerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($dealerId);
}
