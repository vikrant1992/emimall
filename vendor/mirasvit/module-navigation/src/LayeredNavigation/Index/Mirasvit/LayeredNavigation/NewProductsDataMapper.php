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
 * @package   mirasvit/module-navigation
 * @version   1.0.77
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\LayeredNavigation\Index\Mirasvit\LayeredNavigation;

use Magento\Framework\App\ResourceConnection;
use Mirasvit\LayeredNavigation\Model\Config\AdditionalFiltersConfig;
use Mirasvit\LayeredNavigation\Service\Filter\FilterNewService;

class NewProductsDataMapper
{
    /**
     * @var AdditionalFiltersConfig
     */
    private $filterConfig;

    /**
     * @var ResourceConnection
     */
    private $resource;

    private $newFilterService;

    public function __construct(
        ResourceConnection $resource,
        FilterNewService $newFilterService,
        AdditionalFiltersConfig $filterConfig
    ) {
        $this->filterConfig     = $filterConfig;
        $this->resource         = $resource;
        $this->newFilterService = $newFilterService;
    }

    /**
     * @param array                                         $documents
     * @param \Magento\Framework\Search\Request\Dimension[] $dimensions
     * @param string                                        $indexIdentifier
     *
     * @return array
     */
    public function map(array $documents, $dimensions, $indexIdentifier)
    {
        if (!$this->filterConfig->isNewFilterEnabled()) {
            return $documents;
        }

        $scope = $this->newFilterService->getCurrentScope($dimensions);
        $table = new \Magento\Framework\Db\Ddl\Table();
        $table->setName($this->resource->getTableName('catalog_product_entity'));

        $select = $this->newFilterService->createNewFilterSelectWithIds($scope, $table);
        $select->where('entities.entity_id IN(?)', array_keys($documents));

        $rows = [];
        foreach ($this->resource->getConnection()->fetchAll($select) as $product) {
            $rows[$product['entity_id']] = (int)$product['value']; // for "range" filter value should be integer
        }

        foreach ($documents as $id => $doc) {
            $doc[AdditionalFiltersConfig::NEW_FILTER . '_raw'] = isset($rows[$id]) ? $rows[$id] : 0;
            $documents[$id]                                    = $doc;
        }

        return $documents;
    }
}
