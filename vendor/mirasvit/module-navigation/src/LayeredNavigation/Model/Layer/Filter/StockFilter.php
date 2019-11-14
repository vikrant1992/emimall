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



namespace Mirasvit\LayeredNavigation\Model\Layer\Filter;

use Magento\Catalog\Model\Layer;
use Magento\Catalog\Model\Layer\Filter\AbstractFilter;
use Magento\Catalog\Model\Layer\Filter\Item\DataBuilder;
use Magento\Catalog\Model\Layer\Filter\ItemFactory;
use Magento\Store\Model\StoreManagerInterface;
use Mirasvit\LayeredNavigation\Model\Config\AdditionalFiltersConfig;
use Mirasvit\LayeredNavigation\Model\Config\ConfigTrait;
use Mirasvit\LayeredNavigation\Model\Config\FilterClearBlockConfig;
use Mirasvit\LayeredNavigation\Service\Filter\FilterStockService;
use Mirasvit\LayeredNavigation\Service\FilterDataService;

/**
 * Stock filter
 */
class StockFilter extends AbstractFilter
{
    use ConfigTrait;

    /**
     * @var string
     */
    protected $attributeCode = AdditionalFiltersConfig::STOCK_FILTER;

    /**
     * @var bool
     */
    protected $isAdded = false;

    /**
     * @var bool
     */
    protected static $isStateAdded = [];

    public function __construct(
        ItemFactory $filterItemFactory,
        StoreManagerInterface $storeManager,
        Layer $layer,
        DataBuilder $itemDataBuilder,
        FilterDataService $filterDataService,
        FilterStockService $filterStockService,
        AdditionalFiltersConfig $additionalFiltersConfig,
        FilterClearBlockConfig $filterClearBlockConfig,
        array $data = []
    ) {
        parent::__construct(
            $filterItemFactory,
            $storeManager,
            $layer,
            $itemDataBuilder,
            $data
        );
        $this->_requestVar             = AdditionalFiltersConfig::STOCK_FILTER_FRONT_PARAM;
        $this->filterDataService       = $filterDataService;
        $this->filterStockService      = $filterStockService;
        $this->additionalFiltersConfig = $additionalFiltersConfig;
        $this->storeManager            = $storeManager;
        $this->filterClearBlockConfig  = $filterClearBlockConfig;
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     *
     * @return $this
     */
    public function apply(\Magento\Framework\App\RequestInterface $request)
    {
        if (!$this->additionalFiltersConfig->isStockFilterEnabled($this->storeManager->getStore()->getStoreId())) {
            return $this;
        }
        $filter = $request->getParam(AdditionalFiltersConfig::STOCK_FILTER_FRONT_PARAM);

        $filterPrepared = false;
        if ($filter && strpos($filter, ',') !== false) {
            $filterPrepared = explode(',', $filter);
        }

        if ($filter && $filterPrepared) {
            $this->addState(false, $filterPrepared);
            $this->isAdded = true;
        } elseif ($filter) {
            $productCollection = $this->getLayer()->getProductCollection();
            $productCollection->addFieldToFilter($this->attributeCode,
                ($filter == AdditionalFiltersConfig::IN_STOCK_FILTER) ? 1 : 0
            );
            $this->addState($this->getStateLabel($filter), $filter);
            $this->isAdded = true;
        }

        return $this;
    }

    /**
     * @param string $label
     * @param string $filter
     * return void
     */
    private function addState($label, $filter)
    {
        $state = is_array($filter) ? $this->_requestVar . implode('_', $filter) : $this->_requestVar . $filter;
        if (isset(self::$isStateAdded[$state])) { //avoid double state adding (horizontal filters)
            return true;
        }

        if (is_array($filter) && !$label && $this->filterClearBlockConfig->isFilterClearBlockInOneRow()) {
            $labels = [];
            foreach ($filter as $filterValue) {
                $labels[] = $this->getStateLabel($filterValue);
            }
            $this->getLayer()->getState()
                ->addFilter($this->_createItem(implode(', ', $labels), $filter));
        } elseif (is_array($filter) && !$label) {
            foreach ($filter as $filterValue) {
                $this->getLayer()->getState()
                    ->addFilter($this->_createItem($this->getStateLabel($filterValue), $filterValue));
            }
        } else {
            $this->getLayer()->getState()->addFilter($this->_createItem($label, $filter));
        }

        self::$isStateAdded[$state] = true;

        return true;
    }

    /**
     * Get filter state label
     * @return string
     */
    private function getStateLabel($filter)
    {
        $storeId    = $this->storeManager->getStore()->getStoreId();
        $stateLabel = ($filter == AdditionalFiltersConfig::IN_STOCK_FILTER)
            ? $this->additionalFiltersConfig->getInStockFilterLabel($storeId)
            : $this->additionalFiltersConfig->getOutOfStockFilterLabel($storeId);

        if (!$stateLabel) {
            $stateLabel = ($filter == AdditionalFiltersConfig::IN_STOCK_FILTER)
                ? 'In Stock'
                : 'Out of Stock';
        }

        return $stateLabel;
    }

    /**
     * Get filter text label
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getName()
    {
        $stockName = $this->additionalFiltersConfig->getStockFilterLabel($this->storeManager->getStore()->getStoreId());
        $stockName = ($stockName) ? : AdditionalFiltersConfig::STOCK_FILTER_DEFAULT_LABEL;

        return $stockName;
    }

    /**
     * Get data array for building category filter items
     * @return array
     */
    protected function _getItemsData()
    {
        if (!$this->additionalFiltersConfig->isStockFilterEnabled($this->storeManager->getStore()->getStoreId())
            || $this->isAdded && !ConfigTrait::isMultiselectEnabled()) {
            return [];
        }

        $productCollection = $this->getLayer()->getProductCollection();
        $requestBuilder    = clone $productCollection->getCloneRequestBuilder();
        $requestBuilder->removePlaceholder($this->attributeCode);
        $queryRequest       = $requestBuilder->create();
        $optionsFacetedData = $this->filterDataService->getFilterBucketData($queryRequest, $this->attributeCode);
        $optionsData        = [
            [
                'label' => $this->getStateLabel(AdditionalFiltersConfig::IN_STOCK_FILTER),
                'value' => AdditionalFiltersConfig::IN_STOCK_FILTER,
                'count' => isset($optionsFacetedData[1]) ? $optionsFacetedData[1]['count'] : 0,
            ],
            [
                'label' => $this->getStateLabel(AdditionalFiltersConfig::OUT_OF_STOCK_FILTER),
                'value' => AdditionalFiltersConfig::OUT_OF_STOCK_FILTER,
                'count' => isset($optionsFacetedData[0]) ? $optionsFacetedData[0]['count'] : 0,
            ],
        ];
        foreach ($optionsData as $data) {
            if ($data['count'] < 1) {
                continue;
            }
            $this->itemDataBuilder->addItemData(
                $data['label'],
                $data['value'],
                $data['count']
            );
        }

        return $this->itemDataBuilder->build();
    }

}
