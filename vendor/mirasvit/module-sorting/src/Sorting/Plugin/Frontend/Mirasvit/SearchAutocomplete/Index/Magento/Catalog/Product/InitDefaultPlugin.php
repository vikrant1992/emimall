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



namespace Mirasvit\Sorting\Plugin\Frontend\Mirasvit\SearchAutocomplete\Index\Magento\Catalog\Product;

use Mirasvit\Sorting\Service\CriteriaApplierService;
use Mirasvit\Sorting\Service\CriteriaManagementService;

class InitDefaultPlugin
{
    private $criteriaManagement;

    public function __construct(
        CriteriaManagementService $criteriaManagement
    ) {
        $this->criteriaManagement = $criteriaManagement;
    }

    public function afterGetCollection($subject, $collection)
    {
        $criterion = $this->criteriaManagement->getDefaultCriterion();

        if ($criterion) {
            $collection->setFlag(CriteriaApplierService::FLAG_CRITERION, $criterion);
        }

        return $collection;
    }
}