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

interface DealercategoryRepositoryInterface
{

    /**
     * Save Dealercategory
     * @param \Cybage\Storelocator\Api\Data\DealercategoryInterface $dealercategory
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Cybage\Storelocator\Api\Data\DealercategoryInterface $dealercategory
    );

    /**
     * Retrieve Dealercategory
     * @param string $dealercategoryId
     * @return \Cybage\Storelocator\Api\Data\DealercategoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($dealercategoryId);

    /**
     * Retrieve Dealercategory matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Cybage\Storelocator\Api\Data\DealercategorySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Dealercategory
     * @param \Cybage\Storelocator\Api\Data\DealercategoryInterface $dealercategory
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Cybage\Storelocator\Api\Data\DealercategoryInterface $dealercategory
    );

    /**
     * Delete Dealercategory by ID
     * @param string $dealercategoryId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($dealercategoryId);
}
