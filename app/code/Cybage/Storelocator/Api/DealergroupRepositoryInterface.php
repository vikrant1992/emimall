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

interface DealergroupRepositoryInterface
{

    /**
     * Save Dealergroup
     * @param \Cybage\Storelocator\Api\Data\DealergroupInterface $dealergroup
     * @return \Cybage\Storelocator\Api\Data\DealergroupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Cybage\Storelocator\Api\Data\DealergroupInterface $dealergroup
    );

    /**
     * Retrieve Dealergroup
     * @param string $dealergroupId
     * @return \Cybage\Storelocator\Api\Data\DealergroupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($dealergroupId);

    /**
     * Retrieve Dealergroup matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Cybage\Storelocator\Api\Data\DealergroupSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Dealergroup
     * @param \Cybage\Storelocator\Api\Data\DealergroupInterface $dealergroup
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Cybage\Storelocator\Api\Data\DealergroupInterface $dealergroup
    );

    /**
     * Delete Dealergroup by ID
     * @param string $dealergroupId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($dealergroupId);
}
