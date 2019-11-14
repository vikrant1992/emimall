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



namespace Mirasvit\Sorting\Service;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\App\ResourceConnection;
use Mirasvit\Sorting\Api\Data\CriterionInterface;
use Mirasvit\Sorting\Api\Data\IndexInterface;
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;

class CriteriaService
{
    private $criteriaApplierService;

    private $productCollectionFactory;

    private $resource;

    public function __construct(
        CriteriaApplierService $criteriaApplierService,
        ProductCollectionFactory $productCollectionFactory,
        ResourceConnection $connection

    ) {
        $this->criteriaApplierService   = $criteriaApplierService;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->resource                 = $connection;
    }

    public function getCriterionScore(CriterionInterface $criterion, $productIds)
    {
        if (!count($productIds)) {
            return [];
        }

        $collection = $this->productCollectionFactory->create();
        $collection->addFieldToFilter('entity_id', $productIds);

        $collection->setFlag(CriteriaApplierService::FLAG_GLOBAL, true);
        $collection->setFlag(CriteriaApplierService::FLAG_CRITERION, $criterion);

        $collection = $this->criteriaApplierService->processCollection($collection);

        $rows = $this->resource->getConnection()
            ->fetchAll($collection->getSelect());

        $result = [];
        foreach ($rows as $row) {
            $id     = $row['entity_id'];
            $global = isset($row['sorting_score_global']) ? $row['sorting_score_global'] : 0;
            $local  = isset($row['sorting_score_criterion']) ? $row['sorting_score_criterion'] : 0;

            $result[$id] = $global + $local;
        }

        return $result;
    }

    public function getFactorScore(RankingFactorInterface $factor, $productIds)
    {
        if (!count($productIds)) {
            return [];
        }

        $select = $this->resource->getConnection()->select();
        $select->from($this->resource->getTableName(IndexInterface::TABLE_NAME))
            ->where(IndexInterface::FACTOR_ID . '= ?', $factor->getId())
            ->where(IndexInterface::PRODUCT_ID . ' IN (?)', $productIds);


        $rows = $this->resource->getConnection()
            ->fetchAll($select);


        $result = [];
        foreach ($rows as $row) {
            $id    = $row[IndexInterface::PRODUCT_ID];
            $score = $row[IndexInterface::VALUE];

            $result[$id] = $score;
        }

        return $result;
    }
}