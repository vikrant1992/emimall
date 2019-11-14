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

class RatingFactor implements FactorInterface
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
        return 'Product Rating';
    }

    public function getDescription()
    {
        return '';
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
            ['e' => $resource->getTableName('catalog_product_entity')],
            ['entity_id']
        )->joinInner(
            ['vote' => $resource->getTableName('rating_option_vote')],
            'vote.entity_pk_value = e.entity_id',
            ['value' => new \Zend_Db_Expr('AVG(vote.percent) - 1 + COUNT(vote.vote_id) / 1000')]
        )->joinInner(
            ['review' => $resource->getTableName('review')],
            'review.review_id = vote.review_id',
            []
        )->where('review.status_id=1')
            ->group('e.entity_id');

        $stmt = $connection->query($select);

        while ($row = $stmt->fetch()) {
            $value = $row['value'];
            $this->indexer->insertRow($rankingFactor, $row['entity_id'], $value);
        }
    }
}