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



namespace Mirasvit\Sorting\Plugin\Frontend\Catalog\Model\ResourceModel\Product\Collection;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Db\Select;
use Mirasvit\Sorting\Api\Repository\CriterionRepositoryInterface;
use Mirasvit\Sorting\Service\CriteriaApplierService;

class ApplySortingPlugin
{
    static  $increment = 1;

    private $criterionRepository;

    private $criteriaApplierService;

    public function __construct(
        CriteriaApplierService $criteriaApplierService,
        CriterionRepositoryInterface $criterionRepository
    ) {
        $this->criterionRepository    = $criterionRepository;
        $this->criteriaApplierService = $criteriaApplierService;
    }

    public function beforeAddAttributeToSort(Collection $collection, $attribute, $dir = Select::SQL_DESC)
    {
        return $this->beforeSetOrder($collection, $attribute, $dir);
    }

    /**
     * Apply sort criteria to collection.
     *
     * @param Collection $collection
     * @param string     $attribute
     * @param string     $dir
     *
     * @return array
     */
    public function beforeSetOrder(Collection $collection, $attribute, $dir = Select::SQL_DESC)
    {
        self::$increment++;

        if (!$collection->getFlag('increment')) {
            $collection->setFlag('increment', self::$increment);
        }

        if ($collection->getFlag($attribute)) {
            return [$attribute, $dir];
        }

        $collection->setFlag($attribute, true);

        $this->criteriaApplierService->applyGlobalRankingFactors($collection);

        $criterion = $this->criterionRepository->getByCode($attribute);
        if ($criterion) {
            $this->criteriaApplierService->applyCriterion($criterion, $collection, $dir);
        }

        return [$attribute, $dir];
    }

}
