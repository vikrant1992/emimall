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
use Magento\Framework\Registry;
use Magento\Framework\View\Element\BlockFactory;
use Magento\Store\Model\StoreManagerInterface;
use Mirasvit\LayeredNavigation\Model\Config\AdditionalFiltersConfig;
use Mirasvit\LayeredNavigation\Model\Config\ConfigTrait;
use Mirasvit\LayeredNavigation\Model\Config\FilterClearBlockConfig;
use Mirasvit\LayeredNavigation\Service\Filter\FilterRatingService;
use Mirasvit\LayeredNavigation\Service\FilterDataService;

/**
 * Rating filter
 */
class RatingFilter extends AbstractFilter
{
    use ConfigTrait;

    /**
     * @var string
     */
    protected $attributeCode = AdditionalFiltersConfig::RATING_FILTER;

    /**
     * @var array
     */
    protected $ratingData = AdditionalFiltersConfig::RATING_DATA;

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
        FilterRatingService $filterRatingService,
        AdditionalFiltersConfig $additionalFiltersConfig,
        BlockFactory $blockFactory,
        Registry $registry,
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
        $this->_requestVar             = AdditionalFiltersConfig::RATING_FILTER_FRONT_PARAM;
        $this->filterDataService       = $filterDataService;
        $this->filterRatingService     = $filterRatingService;
        $this->additionalFiltersConfig = $additionalFiltersConfig;
        $this->storeManager            = $storeManager;
        $this->blockFactory            = $blockFactory;
        $this->registry                = $registry;
        $this->filterClearBlockConfig  = $filterClearBlockConfig;
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     *
     * @return $this
     */
    public function apply(\Magento\Framework\App\RequestInterface $request)
    {
        if (!$this->additionalFiltersConfig->isRatingFilterEnabled($this->storeManager->getStore()->getStoreId())) {
            return $this;
        }
        $filter = $request->getParam(AdditionalFiltersConfig::RATING_FILTER_FRONT_PARAM);

        $filterPrepared    = false;
        $filterRatingExist = true;
        if ($filter && strpos($filter, ',') !== false) {
            $filterPrepared = explode(',', $filter);
            foreach ($filterPrepared as $filterValue) {
                if (!isset($this->ratingData[$filterValue])) {
                    $filterRatingExist = false;
                }
            }
        }

        if ($filter && $filterPrepared && $filterRatingExist) {
            $productCollection = $this->getLayer()->getProductCollection();
            $productCollection->addFieldToFilter(AdditionalFiltersConfig::RATING_FILTER,
                $this->ratingData[min($filterPrepared)]
            );
            $this->addState(false, $filterPrepared);
            $this->isAdded = true;
        } elseif ($filter && isset($this->ratingData[$filter])) {
            $productCollection = $this->getLayer()->getProductCollection();
            $productCollection->addFieldToFilter(AdditionalFiltersConfig::RATING_FILTER,
                $this->ratingData[$filter]
            );
            $this->addState(__('%1 & Up', $filter), $filter);
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
                $labels[] = __('%1 & Up', $filterValue);
            }
            $this->getLayer()->getState()
                ->addFilter($this->_createItem(implode(', ', $labels), $filter));
        } elseif (is_array($filter) && !$label) {
            foreach ($filter as $filterValue) {
                $this->getLayer()->getState()
                    ->addFilter($this->_createItem(__('%1 & Up', $filterValue), $filterValue));
            }
        } else {
            $this->getLayer()->getState()->addFilter($this->_createItem($label, $filter));
        }


        self::$isStateAdded[$state] = true;

        return true;
    }

    /**
     * Get filter text label
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getName()
    {
        $stockName = $this->additionalFiltersConfig
            ->getRatingFilterLabel($this->storeManager->getStore()->getStoreId());
        $stockName = ($stockName) ? : AdditionalFiltersConfig::RATING_FILTER_DEFAULT_LABEL;

        return $stockName;
    }

    /**
     * Get data array for building category filter items
     * @return array
     */
    protected function _getItemsData()
    {
        if (!$this->additionalFiltersConfig->isRatingFilterEnabled($this->storeManager->getStore()->getStoreId())
            || $this->isAdded && !ConfigTrait::isMultiselectEnabled()) {
            return [];
        }

        $productCollection = $this->getLayer()->getProductCollection();
        $requestBuilder    = clone $productCollection->getCloneRequestBuilder();
        $requestBuilder->removePlaceholder($this->attributeCode);
        $queryRequest       = $requestBuilder->create();
        $optionsFacetedData = $this->filterDataService->getFilterBucketData($queryRequest, $this->attributeCode);

        $optionsData = [];
        $globalCount = 0;
        foreach ($this->ratingData as $rating => $ratingPercent) {

            $globalCount += isset($optionsFacetedData[$rating]) ? $optionsFacetedData[$rating]['count'] : 0;

            $optionsData[$rating] = [
                'label'          => $rating,
                'value'          => $rating,
                'count'          => $globalCount,
                'products_count' => isset($optionsFacetedData[$rating]) ? $optionsFacetedData[$rating]['count'] : 0,
            ];
        }

        foreach ($optionsData as $data) {
            if ($data['products_count'] < 1) {
                continue;
            }
            $this->itemDataBuilder->addItemData(
                $data['label'],
                $data['value'],
                $data['count']
            );
        }

        $itemData = $this->itemDataBuilder->build();

        if (!$optionsData) {
            return [];
        }

        $this->registry->register(AdditionalFiltersConfig::RATING_FILTER_DATA,
            $this->prepareRatingData($itemData),
            true
        );

        return $itemData;
    }

    /**
     * @param int $countStars
     *
     * @return string
     */
    private function prepareRatingData($itemData)
    {
        $itemDataPrepared = [];
        foreach ($itemData as $item) {
            $itemDataPrepared[$item['value']] = $item;
        }

        return $itemDataPrepared;
    }

}
