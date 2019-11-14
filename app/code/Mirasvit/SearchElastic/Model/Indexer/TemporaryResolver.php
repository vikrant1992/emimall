<?php

namespace Mirasvit\SearchElastic\Model\Indexer;

use Magento\Framework\Indexer\ScopeResolver\IndexScopeResolver;
use Magento\Framework\Search\Request\Dimension;
use Magento\Framework\Search\Request\IndexScopeResolverInterface;

/**
 * Resolves name of a temporary table for indexation
 */
class TemporaryResolver implements IndexScopeResolverInterface
{
    static $suffix = null;
    /**
     * @var IndexScopeResolver
     */
    private $indexScopeResolver;

    /**
     * @inheritDoc
     */
    public function __construct(IndexScopeResolver $indexScopeResolver)
    {
        $this->indexScopeResolver = $indexScopeResolver;

        self::$suffix = '_tmp';
    }

    /**
     * @param string $index
     * @param Dimension[] $dimensions
     * @return string
     */
    public function resolve($index, array $dimensions)
    {
        $indexName = $this->indexScopeResolver->resolve($index, $dimensions);
        $indexName .= self::$suffix;

        return $indexName;
    }
}
