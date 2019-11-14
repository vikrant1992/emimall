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

interface OfferRepositoryInterface
{

    /**
     * Save Offer
     * @param \Cybage\Storelocator\Api\Data\OfferInterface $offer
     * @return \Cybage\Storelocator\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Cybage\Storelocator\Api\Data\OfferInterface $offer
    );

    /**
     * Retrieve Offer
     * @param string $offerId
     * @return \Cybage\Storelocator\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($offerId);

    /**
     * Retrieve Offer matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Cybage\Storelocator\Api\Data\OfferSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Offer
     * @param \Cybage\Storelocator\Api\Data\OfferInterface $offer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Cybage\Storelocator\Api\Data\OfferInterface $offer
    );

    /**
     * Delete Offer by ID
     * @param string $offerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($offerId);
}
