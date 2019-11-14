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



namespace Mirasvit\Sorting\Factor;

use Mirasvit\Sorting\Api\Data\IndexInterface;
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;

class PopularityFactor implements FactorInterface
{
    const ZERO_POINT = 'zero_point';

    private $context;

    private $indexer;

    public function __construct(
        Context $context,
        Indexer $indexer
    ) {
        $this->context = $context;
        $this->indexer = $indexer;
    }

    public function getName()
    {
        return 'Popularity';
    }

    public function getDescription()
    {
        return 'Number of Product Views';
    }

    public function getUiComponent()
    {
        return false;
    }

    public function reindexAll(RankingFactorInterface $rankingFactor)
    {
        $this->indexer->delete($rankingFactor);

        $zeroPoint = $rankingFactor->getConfigData(self::ZERO_POINT, 30);

        $date = date('Y-m-d', strtotime('-' . $zeroPoint . ' day', time()));

        $resource   = $this->indexer->getResource();
        $connection = $this->indexer->getConnection();

        $select = $connection->select()->from($resource->getTableName('report_viewed_product_index'), [
            'product_id',
            'value' => new \Zend_Db_Expr('COUNT(index_id)'),
        ])
            ->where('added_at >= ?', $date)
            ->group('product_id');

        $views = $connection->fetchPairs($select);

        if (count($views) === 0) {
            return;
        }

        $max = max(array_values($views));

        $this->indexer->startIndexation();

        foreach ($views as $productId => $value) {
            $value = $value / $max * IndexInterface::MAX;

            $this->indexer->add($rankingFactor, $productId, $value);
        }

        $this->indexer->finishIndexation();
    }
}