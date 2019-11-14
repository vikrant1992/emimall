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



namespace Mirasvit\Sorting\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Indexer\ActionInterface as IndexerActionInterface;
use Magento\Framework\Mview\ActionInterface as MviewActionInterface;
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Api\Repository\RankingFactorRepositoryInterface;

class Indexer implements IndexerActionInterface, MviewActionInterface, IdentityInterface
{
    /**
     * Indexer ID in configuration
     */
    const INDEXER_ID = 'mst_sorting';

    private $eventManager;

    private $rankingFactorRepository;

    public function __construct(
        ManagerInterface $eventManager,
        RankingFactorRepositoryInterface $rankingFactorRepository
    ) {
        $this->eventManager            = $eventManager;
        $this->rankingFactorRepository = $rankingFactorRepository;
    }

    /**
     * Execute materialization on ids entities
     *
     * @param int[] $ids
     *
     * @return void
     */
    public function execute($ids)
    {
    }

    /**
     * Execute full indexation
     *
     * @param array $rankingFactorIds
     *
     * @return void
     */
    public function executeFull(array $rankingFactorIds = [])
    {
        $collection = $this->rankingFactorRepository->getCollection();

        if ($rankingFactorIds) {
            $collection->addFieldToFilter(RankingFactorInterface::ID, $rankingFactorIds);
        }

        foreach ($collection as $rankingFactor) {
            $factor = $this->rankingFactorRepository->getFactor($rankingFactor->getType());

            if ($factor) {
                $factor->reindexAll($rankingFactor);
            }
        }

        $this->eventManager->dispatch('clean_cache_by_tags', ['object' => $this]);
    }

    /**
     * Get affected cache tags
     * @return array
     * @codeCoverageIgnore
     */
    public function getIdentities()
    {
        return [
            \Magento\Catalog\Model\Category::CACHE_TAG,
        ];
    }

    /**
     * Execute partial indexation by ID list
     *
     * @param int[] $ids
     *
     * @return void
     */
    public function executeList(array $ids)
    {
    }

    /**
     * Execute partial indexation by ID
     *
     * @param int $id
     *
     * @return void
     */
    public function executeRow($id)
    {
    }
}
