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

class DiscountFactor implements FactorInterface
{
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
        return 'Discount';
    }

    public function getDescription()
    {
        return "Calculation: The difference between regular price and special prices.";
    }

    public function getUiComponent()
    {
        return false;
    }

    public function reindexAll(RankingFactorInterface $rankingFactor)
    {
        $this->indexer->delete($rankingFactor);

        $resource   = $this->indexer->getResource();
        $connection = $this->indexer->getConnection();

        $select = $connection->select();
        $select->from(
            ['e' => $resource->getTableName('catalog_product_index_price')],
            [
                'entity_id',
                'value' => new \Zend_Db_Expr('(price - final_price) / price * 100'),
            ]
        )->group('entity_id');

        $rows = $connection->fetchPairs($select);

        $max = max(array_values($rows));

        $this->indexer->startIndexation();

        foreach ($rows as $productId => $value) {
            $value = $value / $max * IndexInterface::MAX;

            $this->indexer->add($rankingFactor, $productId, $value);
        }

        $this->indexer->finishIndexation();
    }
}