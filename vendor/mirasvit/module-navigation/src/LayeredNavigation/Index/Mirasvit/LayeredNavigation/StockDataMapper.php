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

use Magento\CatalogInventory\Api\StockRegistryInterface;
use Mirasvit\LayeredNavigation\Model\Config\AdditionalFiltersConfig;

class StockDataMapper
{
    /**
     * @var StockRegistryInterface
     */
    private $stockState;

    /**
     * @var AdditionalFiltersConfig
     */
    private $filterConfig;

    public function __construct(
        AdditionalFiltersConfig $filterConfig,
        StockRegistryInterface $stockState
    ) {
        $this->stockState  = $stockState;
        $this->filterConfig = $filterConfig;
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
        if (!$this->filterConfig->isStockFilterEnabled()) {
            return $documents;
        }

        foreach ($documents as $id => $doc) {
            $stockStatus = $this->stockState->getStockStatus($id)->getStockStatus() ? 1 : 0;
            $doc[AdditionalFiltersConfig::STOCK_FILTER . '_raw'] = $stockStatus;

            $documents[$id] = $doc;
        }

        return $documents;
    }
}
