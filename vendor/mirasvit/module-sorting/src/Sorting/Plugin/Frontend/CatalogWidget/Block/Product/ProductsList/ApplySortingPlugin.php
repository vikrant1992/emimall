<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-sorting
 * @version   1.0.25
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\Sorting\Plugin\Frontend\CatalogWidget\Block\Product\ProductsList;

use Mirasvit\Sorting\Api\Repository\CriterionRepositoryInterface;
use Mirasvit\Sorting\Service\CriteriaApplierService;

class ApplySortingPlugin
{
    private $criterionRepository;

    private $criteriaApplierService;

    public function __construct(
        CriterionRepositoryInterface $criterionRepository,
        CriteriaApplierService $criteriaApplierService
    ) {
        $this->criterionRepository    = $criterionRepository;
        $this->criteriaApplierService = $criteriaApplierService;
    }

    /**
     * @param \Magento\CatalogWidget\Block\Product\ProductsList       $subject
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function afterCreateCollection($subject, $collection)
    {
        if (!$collection) {
            return $collection;
        }

        $this->criteriaApplierService->applyGlobalRankingFactors($collection);

        $sortBy = $subject->getData('sort_by');

        if ($sortBy) {
            $criteria = $this->criterionRepository->getByCode($sortBy);

            if (!$criteria) {
                return $collection;
            }

            $this->criteriaApplierService->applyCriterion($criteria, $collection);
        }

        return $collection;
    }
}