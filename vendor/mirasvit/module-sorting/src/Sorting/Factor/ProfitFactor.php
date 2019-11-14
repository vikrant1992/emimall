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

use Mirasvit\Core\Service\CompatibilityService;
use Mirasvit\Sorting\Api\Data\IndexInterface;
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;

class ProfitFactor implements FactorInterface
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
        return 'Profit';
    }

    public function getDescription()
    {
        return "Calculation: The products' price and cost determines the products' ranking of this factor.";
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
        );

        $costAttribute  = $this->context->eavConfig->getAttribute(4, 'cost');
        $priceAttribute = $this->context->eavConfig->getAttribute(4, 'price');

        $select->joinLeft(
            ['cost' => $costAttribute->getBackend()->getTable()],
            implode(' AND ', [
                'cost.attribute_id = ' . $costAttribute->getId(),
                CompatibilityService::isEnterprise()
                    ? 'cost.row_id = e.row_id'
                    : 'cost.entity_id = e.entity_id',
            ]),
            ['cost' => 'value']
        );

        $select->joinLeft(
            ['price' => $priceAttribute->getBackend()->getTable()],
            implode(' AND ', [
                'price.attribute_id = ' . $priceAttribute->getId(),
                CompatibilityService::isEnterprise()
                    ? 'price.row_id = e.row_id'
                    : 'price.entity_id = e.entity_id',
            ]),
            ['price' => 'value']
        );

        $stmt = $connection->query($select);

        $this->indexer->startIndexation();

        while ($row = $stmt->fetch()) {
            $cost  = $row['cost'];
            $price = $row['price'];

            if (!$cost || !$price) {
                $value = 0;
            } elseif ($cost > $price) {
                $value = IndexInterface::MIN;
            } else {
                $value = (1 - $cost / $price) * IndexInterface::MAX;
            }

            $this->indexer->add($rankingFactor, $row['entity_id'], $value);
        }

        $this->indexer->finishIndexation();
    }
}