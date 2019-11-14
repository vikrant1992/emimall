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

namespace Cybage\Attributemapping\Api;

interface AttributesRepositoryInterface {

    /**
     * Save Attributes
     * @param \Cybage\Attributemapping\Api\Data\AttributesInterface $attributes
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
    \Cybage\Attributemapping\Api\Data\AttributesInterface $attributes
    );

    /**
     * Retrieve Attributes
     * @param string $attributesId
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($attributesId);

    /**
     * Retrieve Attributes matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Cybage\Attributemapping\Api\Data\AttributesSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
    \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Attributes
     * @param \Cybage\Attributemapping\Api\Data\AttributesInterface $attributes
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
    \Cybage\Attributemapping\Api\Data\AttributesInterface $attributes
    );

    /**
     * Delete Attributes by ID
     * @param string $attributesId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($attributesId);
}
