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

use Mirasvit\Sorting\Api\Data\RankingFactorInterface;

class BestsellerFactor implements FactorInterface
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
        return 'Bestsellers';
    }

    public function getDescription()
    {
        return '';
    }

    public function getUiComponent()
    {
        return 'sorting_factor_bestseller';
    }

    public function reindexAll(RankingFactorInterface $rankingFactor)
    {
        $this->indexer->delete($rankingFactor);

        $resource   = $this->indexer->getResource();
        $connection = $this->indexer->getConnection();

        $zeroPoint = $rankingFactor->getConfigData(self::ZERO_POINT, 60);

        $date = date('Y-m-d', strtotime('-' . $zeroPoint . ' day', time()));

        $selectA = $connection->select();
        $selectA->from(
            $resource->getTableName('sales_order_item'), [
                'product_id',
                'value' => new \Zend_Db_Expr('SUM(qty_ordered)'),
            ]
        )
            ->where('created_at >= ?', $date)
            ->group('product_id');

        $selectB = $connection->select();
        $selectB->from(
            ['i' => $resource->getTableName('sales_order_item')],
            [
                'product_id' => 'l.parent_id',
                'value' => new \Zend_Db_Expr('SUM(qty_ordered)'),
            ]
        )->joinLeft(
            ['l' => $resource->getTableName('catalog_product_super_link')],
            'l.product_id = i.product_id',
            []
        )
            ->where('created_at >= ?', $date)
            ->where('parent_id > 0')
            ->group('parent_id');


        $select = $connection->select()
            ->from(
                $connection->select()->union([$selectA, $selectB]),
                [
                    'product_id',
                    'value' => new \Zend_Db_Expr('SUM(value)'),
                ])
            ->group('product_id');


        $minMaxSelect = $connection->select()
            ->from(
                $select,
                [
                    'max' => 'MAX(value)',
                    'min' => 'MIN(value)',
                ]
            );

        $minMax = $connection->fetchRow($minMaxSelect);

        $max = $minMax['max'];

        $stmt = $connection->query($select);

        while ($row = $stmt->fetch()) {
            $value = $row['value'];

            $value = $value / $max * 100;

            $this->indexer->insertRow($rankingFactor, $row['product_id'], $value);
        }
    }
}