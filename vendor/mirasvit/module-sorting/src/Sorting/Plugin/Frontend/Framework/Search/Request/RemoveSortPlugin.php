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



namespace Mirasvit\Sorting\Plugin\Frontend\Framework\Search\Request;

use Mirasvit\Sorting\Api\Repository\CriterionRepositoryInterface;

class RemoveSortPlugin
{
    private $criterionRepository;

    public function __construct(
        CriterionRepositoryInterface $criterionRepository
    ) {
        $this->criterionRepository = $criterionRepository;
    }

    public function afterGetSort($subject, $orders)
    {
        if (!$orders || !is_array($orders)) {
            return $orders;
        }

        $used = [];
        foreach ($this->criterionRepository->getCollection() as $criterion) {
            $used[] = $criterion->getCode();
        }

        $result = [];

        foreach ($orders as $order) {
            if (!isset($order['field']) || !in_array($order['field'], $used)) {
                $result[] = $order;
            }
        }

        return $result;
    }
}