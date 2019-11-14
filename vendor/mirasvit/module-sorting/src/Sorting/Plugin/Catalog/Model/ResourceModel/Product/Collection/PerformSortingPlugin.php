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



namespace Mirasvit\Sorting\Plugin\Catalog\Model\ResourceModel\Product\Collection;

use Mirasvit\Sorting\Service\CriteriaApplierService;

class PerformSortingPlugin
{
    private $criteriaApplierService;

    private $collection;

    public function __construct(
        CriteriaApplierService $criteriaApplierService
    ) {
        $this->criteriaApplierService = $criteriaApplierService;
    }

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $subject
     * @param bool                                                    $print
     * @param bool                                                    $log
     *
     * @return array
     */
    public function beforeLoad($subject, $print = false, $log = false)
    {
        if (!$subject->isLoaded()) {
            $this->criteriaApplierService->processCollection($subject);
            $this->collection = $subject;
        }

        return [$print, $log];
    }

    public function afterApply($subject, $result)
    {
        if ($this->collection && !$this->collection->isLoaded()) {
            $this->criteriaApplierService->processCollection($this->collection);
        }

        return $result;
    }
}