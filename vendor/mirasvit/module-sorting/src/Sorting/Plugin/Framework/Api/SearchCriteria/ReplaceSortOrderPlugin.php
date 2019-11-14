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



namespace Mirasvit\Sorting\Plugin\Framework\Api\SearchCriteria;

use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Api\Repository\CriterionRepositoryInterface;
use Mirasvit\Sorting\Api\Repository\RankingFactorRepositoryInterface;
use Mirasvit\Sorting\Model\Config;

class ReplaceSortOrderPlugin
{
    private $config;

    private $criterionRepository;

    private $rankingFactorRepository;

    public function __construct(
        Config $config,
        CriterionRepositoryInterface $criterionRepository,
        RankingFactorRepositoryInterface $rankingFactorRepository
    ) {
        $this->config                  = $config;
        $this->criterionRepository     = $criterionRepository;
        $this->rankingFactorRepository = $rankingFactorRepository;
    }

    public function beforeSetSortOrders($subject, $orders)
    {
        if ($this->config->isElasticSearch() == false) {
            return [$orders];
        }

        $newOrders = [];

        $global = $this->rankingFactorRepository->getCollection();
        $global->addFieldToFilter(RankingFactorInterface::IS_ACTIVE, 1)
            ->addFieldToFilter(RankingFactorInterface::IS_GLOBAL, 1);

        foreach ($global as $factor) {
            $newOrders['sorting_factor_' . $factor->getId()] = 'DESC';
        }

        foreach ($orders as $attr => $direction) {
            $criterion = $this->criterionRepository->getByCode($attr);
            if ($criterion) {
                $newOrders['sorting_criteria_' . $criterion->getId()] = $direction;
            }

            $newOrders[$attr] = $direction;
        }

        return [$newOrders];
    }
}