<?php
namespace Mirasvit\SearchElastic\Model\Search;

use Magento\Framework\Search\RequestInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Search\Adapter\Mysql\IndexBuilderInterface;

class IndexBuilder implements IndexBuilderInterface
{
    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @var \Magento\CatalogSearch\Model\Search\TableMapper
     */
    private $tableMapper;

    /**
     * @param ResourceConnection                              $resource
     * @param \Magento\CatalogSearch\Model\Search\TableMapper $tableMapper
     */
    public function __construct(
        ResourceConnection $resource,
        \Magento\CatalogSearch\Model\Search\TableMapper $tableMapper
    ) {
        $this->resource = $resource;
        $this->tableMapper = $tableMapper;
    }

    /**
     * @param RequestInterface $request
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function build(RequestInterface $request)
    {
    }
}
