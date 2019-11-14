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



namespace Mirasvit\Sorting\Plugin\Elasticsearch\Model\Adapter\Elasticsearch;

use Mirasvit\Sorting\Api\Repository\CriterionRepositoryInterface;
use Mirasvit\Sorting\Api\Repository\RankingFactorRepositoryInterface;
use Mirasvit\Sorting\Service\CriteriaService;

class PutScorePlugin
{
    private $criterionRepository;

    private $rankingFactorRepository;

    private $criteriaService;

    public function __construct(
        CriterionRepositoryInterface $criterionRepository,
        RankingFactorRepositoryInterface $rankingFactorRepository,
        CriteriaService $criteriaService
    ) {
        $this->criterionRepository     = $criterionRepository;
        $this->rankingFactorRepository = $rankingFactorRepository;
        $this->criteriaService         = $criteriaService;
    }

    public function afterPrepareDocsPerStore($subject, $docs)
    {
        $productIds = array_keys($docs);

        foreach ($this->rankingFactorRepository->getCollection() as $factor) {
            $scores = $this->criteriaService->getFactorScore($factor, $productIds);

            foreach ($productIds as $id) {
                $docs[$id]['sorting_factor_' . $factor->getId()] = $this->fetchScore($scores, $id);
            }
        }

        foreach ($this->criterionRepository->getCollection() as $criterion) {
            $scores = $this->criteriaService->getCriterionScore($criterion, $productIds);

            foreach ($productIds as $id) {
                $docs[$id]['sorting_criteria_' . $criterion->getId()] = $this->fetchScore($scores, $id);
            }
        }

        return $docs;
    }

    private function fetchScore($list, $id)
    {
        if (!isset($list[$id])) {
            return 1;
        }

        return $list[$id] >= 1 ? intval($list[$id]) : 1;
    }
}