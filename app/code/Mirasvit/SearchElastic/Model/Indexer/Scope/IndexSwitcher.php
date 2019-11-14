<?php

namespace Mirasvit\SearchElastic\Model\Indexer\Scope;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Registry;
use Mirasvit\SearchElastic\Model\Engine;
use Mirasvit\SearchElastic\Model\Indexer\IndexerHandler;
use Mirasvit\Core\Service\CompatibilityService;

class IndexSwitcher extends IndexSwitcherParent
{
    /**
     * @var Resource
     */
    private $resource;

    /**
     * @var ScopeProxy / IndexScopeResolver
     */
    private $resolver;

    /**
     * @var State
     */
    private $state;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var Engine
     */
    private $engine;

    /**
     * @param ResourceConnection $resource
     * @param IndexScopeResolverInterface $indexScopeResolver
     * @param State $state
     */
    public function __construct(
        ResourceConnection $resource,
        StateMediator $state,
        Registry $registry,
        Engine $engine
    ) {
        $this->resource = $resource;
        $this->state = $state->get();
        $this->registry = $registry;
        $this->engine = $engine;
        if (CompatibilityService::is22() || CompatibilityService::is23()) {
            $this->resolver = CompatibilityService::getObjectManager()
                ->create('Magento\CatalogSearch\Model\Indexer\Scope\ScopeProxy');
        } else {
            $this->resolver = CompatibilityService::getObjectManager()
                ->create('Magento\Framework\Indexer\ScopeResolver\IndexScopeResolver');
        }
    }

    /**
     * {@inheritdoc}
     * @throws IndexTableNotExistException
     */
    public function switchIndex(array $dimensions)
    {
        if (StateMediator::USE_TEMPORARY_INDEX === $this->state->getState()) {
            $index = $this->registry->registry(IndexerHandler::ACTIVE_INDEX);

            $temporalIndexTable = $this->resolver->resolve($index, $dimensions);

            $this->state->useRegularIndex();

            $tableName = $this->resolver->resolve($index, $dimensions);

            $this->engine->removeIndex($tableName);
            $this->engine->moveIndex($temporalIndexTable, $tableName);

            $this->state->useTemporaryIndex();
        }
    }
}
