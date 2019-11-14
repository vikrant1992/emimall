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

namespace Cybage\Storelocator\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface OffertypeRepositoryInterface
{

    /**
     * Save Offertype
     * @param \Cybage\Storelocator\Api\Data\OffertypeInterface $offertype
     * @return \Cybage\Storelocator\Api\Data\OffertypeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Cybage\Storelocator\Api\Data\OffertypeInterface $offertype
    );

    /**
     * Retrieve Offertype
     * @param string $offertypeId
     * @return \Cybage\Storelocator\Api\Data\OffertypeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($offertypeId);

    /**
     * Retrieve Offertype matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Cybage\Storelocator\Api\Data\OffertypeSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Offertype
     * @param \Cybage\Storelocator\Api\Data\OffertypeInterface $offertype
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Cybage\Storelocator\Api\Data\OffertypeInterface $offertype
    );

    /**
     * Delete Offertype by ID
     * @param string $offertypeId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($offertypeId);
}