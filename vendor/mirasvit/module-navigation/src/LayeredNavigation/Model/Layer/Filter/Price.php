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
use Magento\Catalog\Model\Layer\Filter\DataProvider\PriceFactory;
use Magento\Catalog\Model\Layer\Filter\Dynamic\AlgorithmFactory;
use Magento\Catalog\Model\Layer\Filter\Item\DataBuilder;
use Magento\Catalog\Model\Layer\Filter\ItemFactory;
use Magento\Catalog\Model\ResourceModel\Layer\Filter\Price as LayerFilterPrice;
use Magento\CatalogSearch\Model\Layer\Filter\Price as CatalogSearchPrice;
use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Registry;
use Magento\Framework\Search\Dynamic\Algorithm;
use Magento\Store\Model\StoreManagerInterface;
use Mirasvit\LayeredNavigation\Model\Config\ConfigTrait;
use Mirasvit\LayeredNavigation\Model\Config\FilterClearBlockConfig;
use Mirasvit\LayeredNavigation\Model\Config\HorizontalFiltersConfig;
use Mirasvit\LayeredNavigation\Model\Config\SliderConfig;
use Mirasvit\LayeredNavigation\Model\Config\Source\HorizontalFilterOptions;
use Mirasvit\LayeredNavigation\Service\FilterDataService;
use Mirasvit\LayeredNavigation\Service\SliderService;

/**
 * Price filter
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Price extends CatalogSearchPrice
{
    use ConfigTrait;

    /** Price delta for filter  */
    const PRICE_DELTA = 0.001;

    /**
     * @var \Magento\Catalog\Model\Layer\Filter\DataProvider\Price
     */
    protected $dataProvider;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var array
     */
    protected $facetedData;

    /**
     * @var bool
     */
    protected static $isStateAdded = [];

    /**
     * @var bool
     */
    protected static $isAdded;

    /**
     * @var bool
     */
    protected $isFromToDataAdded;

    private   $sliderConfig;

    private   $filterClearBlockConfig;

    private   $storeId;

    public function __construct(
        Registry $registry,
        ItemFactory $filterItemFactory,
        StoreManagerInterface $storeManager,
        Layer $layer,
        DataBuilder $itemDataBuilder,
        LayerFilterPrice $resource,
        Session $customerSession,
        Algorithm $priceAlgorithm,
        PriceCurrencyInterface $priceCurrency,
        AlgorithmFactory $algorithmFactory,
        PriceFactory $dataProviderFactory,
        FilterDataService $filterDataService,
        SliderService $sliderService,
        HorizontalFiltersConfig $horizontalFiltersConfig,
        SliderConfig $sliderConfig,
        FilterClearBlockConfig $filterClearBlockConfig,
        array $data = []
    ) {
        parent::__construct(
            $filterItemFactory, $storeManager, $layer, $itemDataBuilder,
            $resource, $customerSession, $priceAlgorithm, $priceCurrency,
            $algorithmFactory, $dataProviderFactory, $data
        );

        $this->registry                = $registry;
        $this->priceCurrency           = $priceCurrency;
        $this->dataProvider            = $dataProviderFactory->create(['layer' => $this->getLayer()]);
        $this->filterDataService       = $filterDataService;
        $this->sliderService           = $sliderService;
        $this->horizontalFiltersConfig = $horizontalFiltersConfig;
        $this->sliderConfig            = $sliderConfig;
        $this->filterClearBlockConfig  = $filterClearBlockConfig;
        $this->storeId                 = $storeManager->getStore()->getStoreId();
    }

    /**
     * Apply price range filter
     *
     * @param \Magento\Framework\App\RequestInterface $request
     *
     * @return $this
     */
    public function apply(RequestInterface $request)
    {
        if (!ConfigTrait::isMultiselectEnabled()) {
            return $this->getDefaultApply($request);
        }

        $attrCode = $this->getRequestVar();
        $filter   = $request->getParam($this->getRequestVar());

        if (!$filter || !is_string($filter)) {
            return $this;
        }

        $fromArray    = [];
        $toArray      = [];
        $filterParams = explode(',', $filter);

        $productCollection = $this->getLayer()->getProductCollection();

        foreach ($filterParams as $filterParam) {
            if (!is_numeric(preg_replace('/[\-:]/', '', $filterParam))) {
                return $this;
            }

            $filterParamArray = preg_split('/[\-:]/', $filterParam);
            $from             = isset($filterParamArray[0]) ? $filterParamArray[0] : false;
            $to               = isset($filterParamArray[1]) ? $filterParamArray[1] : false;

            //            $priceDelta = ($this->sliderConfig->isSliderEnabled($this->storeId, $attrCode)) ? 0 : self::PRICE_DELTA;

            $fromArray[] = $from ? $from : 0;
            $toArray[]   = $to ? $to : 10000000;

            $label    = $this->_renderRangeLabel(empty($from) ? 0 : $from, $to);
            $labels[] = $label;

            if (!$this->filterClearBlockConfig->isFilterClearBlockInOneRow()) {
                $this->addState($label, $filter);
            }
        }

        if ($this->filterClearBlockConfig->isFilterClearBlockInOneRow()) {
            $labels = (count($labels) > 1) ? $labels : $label;
            $this->addState($labels, $filter);
        }

        $from = min($fromArray);
        $to   = max($toArray);

        self::$isAdded = true;

        $this->setFromToData(['from' => $from, 'to' => $to]);

        $productCollection->addFieldToFilter(
            $attrCode,
            ['from' => $from, 'to' => $to]
        );

        return $this;
    }

    /**
     * @param array  $facets
     * @param string $requestVar
     *
     * @return array
     */
    protected function getMinMaxData($facets, $requestVar)
    {
        $minMaxData    = [];
        $sliderDataKey = $this->sliderService->getSliderDataKey($requestVar);
        if (isset($facets[$sliderDataKey]['min'])
            && isset($facets[$sliderDataKey]['max'])) {
            $minMaxData['from'] = $facets[$sliderDataKey]['min'];
            $minMaxData['to']   = $facets[$sliderDataKey]['max'];
        }

        return $minMaxData;
    }


    /**
     * Add data to state
     *
     * @param string $label
     * @param string $attributeValue
     *
     * @return bool
     */
    protected function addState($label, $attributeValue)
    {
        $state = is_array($attributeValue)
            ? $this->_requestVar . implode('_', $attributeValue) : $this->_requestVar . $attributeValue;
        if (isset(self::$isStateAdded[$state])) { //avoid double state adding (horizontal filters)
            return true;
        }

        if (is_array($attributeValue) && !ConfigTrait::isMultiselectEnabled()) {
            $attributeValue = implode('-', $attributeValue);
        }

        if (!is_array($attributeValue)) {
            $attributeValue = $this->getPreparedValue($this->_requestVar, $attributeValue);
        }

        if (!is_array($attributeValue) && strpos($attributeValue, ',') !== false) {
            $attributeValue = explode(',', $attributeValue);
        }

        if (is_array($attributeValue) && is_array($label)) {
            $this->getLayer()->getState()
                ->addFilter($this->_createItem(implode(', ', $label), implode(',', $attributeValue)));
        } elseif (is_array($attributeValue)) {
            foreach ($attributeValue as $attribute) {
                if (strpos($attribute, '-') !== false) {
                    $attributeArray = explode('-', $attribute);
                    $attributeLabel = $this->_renderRangeLabel($attributeArray[0], $attributeArray[1]);
                    $this->getLayer()->getState()
                        ->addFilter($this->_createItem($attributeLabel, $attribute));
                } else {
                    $this->getLayer()->getState()
                        ->addFilter($this->_createItem($attribute, $attribute));
                }
            }
        } else {
            $this->getLayer()->getState()->addFilter(
                $this->_createItem($label, $attributeValue)
            );
        }
        self::$isStateAdded[$state] = true;

        return true;
    }

    /**
     * Prepare not multiselect price
     *
     * @param string $requestVar
     * @param string $value
     *
     * @return string
     */
    public function getPreparedValue($requestVar, $value)
    {
        if ($requestVar != 'price' || $this->isMultiselectEnabled()) {
            return $value;
        }

        return str_replace(',', '-', $value);
    }

    /**
     * Apply price range filter
     *
     * @param \Magento\Framework\App\RequestInterface $request
     *
     * @return $this
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getDefaultApply(\Magento\Framework\App\RequestInterface $request)
    {
        /**
         * Filter must be string: $fromPrice-$toPrice
         */
        $filter = $request->getParam($this->getRequestVar());
        if (!$filter || is_array($filter)) {
            return $this;
        }

        $filterParams = explode(',', $filter);
        $filter       = $this->dataProvider->validateFilter($filterParams[0]);
        if (!$filter) {
            return $this;
        }

        $this->dataProvider->setInterval($filter);
        $priorFilters = $this->dataProvider->getPriorFilters($filterParams);
        if ($priorFilters) {
            $this->dataProvider->setPriorIntervals($priorFilters);
        }

        list($from, $to) = $filter;
        if ($to !== '' && !is_numeric($to)) {
            $to = '';
        }

        self::$isAdded = true;
        $this->getLayer()->getProductCollection()->addFieldToFilter(
            'price',
            ['from' => $from, 'to' => empty($to) || $from == $to ? $to : $to - self::PRICE_DELTA]
        );
        $this->setFromToData(['from' => $from, 'to' => $to]);
        $this->addState($this->_renderRangeLabel(empty($from) ? 0 : $from, $to), $filter);

        return $this;
    }

    /**
     * Get data array for building attribute filter items
     * @return array
     */
    protected function _getItemsData()
    {
        $attribute         = $this->getAttributeModel();
        $this->_requestVar = $attribute->getAttributeCode();

        $facets = $this->getFacetedData();

        $data = [];
        if (count($facets) > 1) {
            foreach ($facets as $key => $aggregation) {
                $count = $aggregation['count'];
                if (strpos($key, '_') === false) {
                    continue;
                }

                $data[] = $this->prepareData($key, $count);
            }
        }

        return $data;
    }

    /**
     * @param string $key
     * @param int    $count
     *
     * @return array
     */
    protected function prepareData($key, $count)
    {
        list($from, $to) = explode('_', $key);
        if ($from == '*') {
            $from = $this->getFrom($to);
        }
        if ($to == '*') {
            $to = '';
        }

        $label = $this->_renderRangeLabel(
            empty($from) ? 0 : $from,
            $to
        );
        $value = $from . '-' . $to . $this->dataProvider->getAdditionalRequestData();
        $data  = [
            'label' => $label,
            'value' => $value,
            'count' => $count,
            'from'  => $from,
            'to'    => $to,
        ];

        return $data;
    }

    /**
     * Prepare text of range label
     *
     * @param float|string $fromPrice
     * @param float|string $toPrice
     *
     * @return float|\Magento\Framework\Phrase
     */
    protected function _renderRangeLabel($fromPrice, $toPrice)
    {
        if (strpos($fromPrice, ',') !== false
            || strpos($toPrice, ',') !== false) {
            return false;
        }

        $fromPrice = empty($fromPrice) ? 0 : $fromPrice * $this->getCurrencyRate();
        $toPrice   = empty($toPrice) ? $toPrice : $toPrice * $this->getCurrencyRate();

        $formattedFromPrice = $this->priceCurrency->format($fromPrice);
        if ($toPrice === '') {
            return __('%1 and above', $formattedFromPrice);
        } elseif ($fromPrice == $toPrice && $this->dataProvider->getOnePriceIntervalValue()) {
            return $formattedFromPrice;
        } else {
            if (!$this->sliderConfig->isSliderEnabled($this->storeId, 'price')) {
                if ($fromPrice != $toPrice) {
                    $toPrice -= .01;
                }
            }

            return __('%1 - %2', $formattedFromPrice, $this->priceCurrency->format($toPrice));
        }
    }

    /**
     * @return array
     */
    public function getFacetedData()
    {
        if (is_null($this->facetedData)) {
            /** @var \Mirasvit\LayeredNavigation\Model\ResourceModel\Fulltext\Collection $productCollection */
            $productCollection = $this->getLayer()->getProductCollection();
            $attribute         = $this->getAttributeModel();

            if (ConfigTrait::isMultiselectEnabled() || $this->sliderService->isSliderEnabled($this->_requestVar)) {
                if (($horizontalFiltersConfig = $this->horizontalFiltersConfig->getHorizontalFilters($this->storeId))
                    && ((is_array($horizontalFiltersConfig) && isset($horizontalFiltersConfig[0])
                            && $horizontalFiltersConfig[0] == 'price')
                        || ($horizontalFiltersConfig == HorizontalFilterOptions::ALL_FILTERED_ATTRIBUTES))) {
                    $productCollection->getData(); /*todo need if only price horizontal enabled*/
                }

                $requestBuilder = clone $productCollection->getCloneRequestBuilder();

                $requestBuilder->removePlaceholder($attribute->getAttributeCode());
                $requestBuilder->removePlaceholder($attribute->getAttributeCode() . '.from');
                $requestBuilder->removePlaceholder($attribute->getAttributeCode() . '.to');

                $queryRequest = $requestBuilder->create();

                $facets = $this->filterDataService->getFilterBucketData($queryRequest, $attribute->getAttributeCode());
            } elseif (self::$isAdded) {
                return [];
            } else {
                $facets = $productCollection->getFacetedData($attribute->getAttributeCode());
            }

            $this->facetedData = $facets;
        }

        return $this->facetedData;
    }

    /**
     * @param string $url
     * @param string $class
     *
     * @return array
     */
    public function getSliderData($url, $class)
    {
        return $this->sliderService->getSliderData(
            $this->getFacetedData(),
            $this->getRequestVar(),
            $this->getFromToData(),
            $url,
            $class
        );
    }

}