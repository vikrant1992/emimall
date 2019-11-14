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

use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Select;
use Mirasvit\Sorting\Api\Data\CriterionInterface;
use Mirasvit\Sorting\Api\Data\IndexInterface;
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Api\Repository\RankingFactorRepositoryInterface;
use Mirasvit\Sorting\Data\ConditionFrame;
use Mirasvit\Sorting\Data\ConditionNode;
use Mirasvit\Sorting\Model\Config;

class CriteriaApplierService
{
    private $rankingFactorRepository;

    private $config;

    private $resource;

    const FLAG_GLOBAL    = 'sorting_global';
    const FLAG_CRITERION = 'sorting_criterion';
    const FLAG_DIRECTION = 'sorting_direction';

    public function __construct(
        RankingFactorRepositoryInterface $rankingFactorRepository,
        Config $config,
        ResourceConnection $resource
    ) {
        $this->rankingFactorRepository = $rankingFactorRepository;
        $this->config                  = $config;
        $this->resource                = $resource;
    }

    public function applyGlobalRankingFactors(AbstractCollection $collection)
    {
        $rankingFactors = $this->rankingFactorRepository->getCollection();
        $rankingFactors->addFieldToFilter(RankingFactorInterface::IS_ACTIVE, 1)
            ->addFieldToFilter(RankingFactorInterface::IS_GLOBAL, 1);

        if ($rankingFactors->getSize()) {
            $collection->setFlag(self::FLAG_GLOBAL, true);
        }

        return $collection;
    }

    /**
     * @inheritdoc
     */
    public function applyCriterion(CriterionInterface $criterion, AbstractCollection $collection, $dir = null)
    {
        $collection->setFlag(self::FLAG_CRITERION, $criterion);
        $collection->setFlag(self::FLAG_DIRECTION, $dir);

        return $collection;
    }

    public function processCollection(AbstractCollection $collection)
    {
        if ($this->config->isElasticSearch()) {
            return $collection;
        }

        $select = clone $collection->getSelect();
        $select->reset(\Zend_Db_Select::ORDER);

        if ($collection->getFlag(self::FLAG_GLOBAL) || $collection->getFlag(self::FLAG_CRITERION)) {
            $collection->getSelect()->reset(\Zend_Db_Select::ORDER);
        } else {
            return $collection;
        }

        if ($collection->getFlag(self::FLAG_GLOBAL)) {
            $rankingFactors = $this->rankingFactorRepository->getCollection();
            $rankingFactors->addFieldToFilter(RankingFactorInterface::IS_ACTIVE, 1)
                ->addFieldToFilter(RankingFactorInterface::IS_GLOBAL, 1);

            $frame = new ConditionFrame();

            foreach ($rankingFactors as $factor) {
                $node = new ConditionNode();
                $node->setRankingFactor($factor->getId())
                    ->setWeight($factor->getWeight());

                $frame->addNode($node);
            }

            $table = $this->summarize($select, $frame);

            $this->join($collection->getSelect(), $table, 'desc', 'global');
            $this->join($select, $table, 'desc', 'global');
        }

        if ($collection->getFlag(self::FLAG_CRITERION)) {
            /** @var CriterionInterface $criterion */
            $criterion = $collection->getFlag(self::FLAG_CRITERION);

            /** @var string $dir */
            $dir = $collection->getFlag(self::FLAG_DIRECTION);

            $cluster    = $criterion->getConditionCluster();
            $useAttrDir = true; // we can change direction only once for the top-level condition

            foreach ($cluster->getFrames() as $idx => $frame) {
                $rankingFrame = new ConditionFrame();

                foreach ($frame->getNodes() as $node) {
                    if (!$dir) {
                        $dir = $node->getDirection();
                    }

                    if ($node->getSortBy() == CriterionInterface::CONDITION_SORT_BY_ATTRIBUTE) {
                        $attribute = $node->getAttribute();
                        $dir       = $useAttrDir ? $dir : $node->getDirection();
                        if ($attribute != 'name') {
                            $collection->setOrder($attribute, $dir);

                            try {
                                $r = new \ReflectionMethod($collection, '_renderOrders');
                                $r->setAccessible(true);
                                $r->invoke($collection);
                            } catch (\Exception $e) {
                            }
                        } else {
                            //                            $collection->getSelect()->reset(\Zend_Db_Select::ORDER);
                            $collection->getSelect()->order('name ' . $dir);
                        }

                        if ($useAttrDir) {
                            $useAttrDir = $useFactDir = false;
                        }
                    } else {
                        $rankingFrame->addNode($node);
                        $useAttrDir = false;
                    }
                }

                $table = $this->summarize($select, $rankingFrame);

                $this->join(
                    $collection->getSelect(),
                    $table,
                    $dir,
                    $idx == 0 ? 'criterion' : 'criterion' . $idx
                );
            }
        }

        if ($this->config->isExtraDebug()) {
            var_dump($collection->getSelect()->assemble());
        }

        return $collection;
    }

    /**
     * @param Select         $select
     * @param ConditionFrame $frame
     *
     * @return Table|false
     */
    private function summarize(Select $select, ConditionFrame $frame)
    {
        if (!count($frame->getNodes())) {
            return false;
        }

        $select = clone $select;
        $select->reset(\Zend_Db_Select::COLUMNS)
            ->columns(['entity_id']);

        $subSelects = [];
        foreach ($frame->getNodes() as $node) {
            $subSelect = clone $select;

            $alias = $this->alias('mst_sorting', $node->getRankingFactor());

            $subSelect->joinInner(
                [$alias => $this->resource->getTableName(IndexInterface::TABLE_NAME)],
                "$alias.product_id = e.entity_id",
                ['score' => new \Zend_Db_Expr($alias . '.value * ' . $node->getWeight())]
            )
                ->where("$alias.factor_id = ?", $node->getRankingFactor())
                ->order('score desc')
                ->group('e.entity_id');

            if ($node->getLimit()) {
                $limit = $node->getLimit();

                if (strpos($limit, '.') !== false) {
                    $limit = explode('.', $limit);
                    $subSelect->limit($limit[0], $limit[1]);
                } else {
                    $subSelect->limit($limit);
                }
            }

            $table = $this->populateTemporaryTable($subSelect);

            $subSelects[] = $this->resource->getConnection()->select()
                ->from($table->getName());
        }

        $unionSelect = $this->resource->getConnection()->select()
            ->from($this->resource->getConnection()->select()->union($subSelects), [])
            ->columns(['sorting_entity_id', 'sorting_score' => new \Zend_Db_Expr('SUM(sorting_score)')])
            ->group('sorting_entity_id')
            ->order('sorting_score desc');

        $insertSelect = $unionSelect;

        $table = $this->populateTemporaryTable($insertSelect);

        return $table;
    }

    /**
     * @param Select      $select
     * @param Table|false $table
     * @param string      $dir
     * @param string      $suffix
     *
     * @return Select
     */
    private function join(Select $select, $table, $dir, $suffix)
    {
        if (!$table) {
            return $select;
        }

        $isJoined = false;

        foreach ($select->getPart(\Zend_Db_Select::FROM) as $item) {
            if ($item['tableName'] === $table->getName()) {
                $isJoined = true;
            }
        }

        if ($isJoined) {
            return $select;
        }

        $alias = $this->alias('mst_sorting', $suffix);

        $select->joinLeft(
            [$alias => $table->getName()],
            $alias . '.sorting_entity_id = e.entity_id',
            ["sorting_score_$suffix" => 'sorting_score']
        )->order("$alias.sorting_score $dir");

        return $select;
    }

    /**
     * @param Select $insertSelect
     *
     * @return Table
     * @throws \Zend_Db_Exception
     */
    private function populateTemporaryTable($insertSelect)
    {
        $connection = $this->resource->getConnection();
        $tableName  = $this->resource->getTableName($this->alias('mst_sorting', 'tmp'));
        $table      = $connection->newTable($tableName);
        $connection->dropTemporaryTable($table->getName());

        $table->addColumn(
            'sorting_entity_id',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity ID'
        );
        $table->addColumn(
            'sorting_score',
            Table::TYPE_INTEGER,
            32,
            ['nullable' => false],
            'Score'
        );

        $table->setOption('type', 'memory');
        $connection->createTemporaryTable($table);

        //        $connection->createTable($table);

        $this->resource->getConnection()
            ->query($this->resource->getConnection()->insertFromSelect($insertSelect, $table->getName()));

        //        echo $insertSelect . PHP_EOL . PHP_EOL;
        //        echo $table->getName() . '<br>' . '<br>' . '<br>' . '<br>';

        return $table;
    }

    private function alias(...$prefix)
    {
        $prefix = implode('_', $prefix) . '_' . substr(sha1(uniqid('', true)), 0, 4);

        return $prefix;
    }
}
