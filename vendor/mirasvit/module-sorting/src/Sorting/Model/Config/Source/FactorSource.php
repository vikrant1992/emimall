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



namespace Mirasvit\Sorting\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Mirasvit\Sorting\Api\Repository\RankingFactorRepositoryInterface;

class FactorSource implements ArrayInterface
{
    private $repository;

    public function __construct(
        RankingFactorRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function toOptionArray()
    {
        $result = [];

        foreach ($this->repository->getFactors() as $identifier => $factor) {
            $result[] = [
                'label' => __($factor->getName()),
                'value' => $identifier
            ];
        }

        return $result;
    }
}