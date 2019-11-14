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

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Layer;
use Magento\Catalog\Model\Layer\Filter\AbstractFilter;
use Magento\Catalog\Model\Layer\Filter\DataProvider\CategoryFactory;
use Magento\Catalog\Model\Layer\Filter\Item\DataBuilder;
use Magento\Catalog\Model\Layer\Filter\ItemFactory;
use Magento\Catalog\Model\Layer\Resolver as LayerResolver;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Escaper;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mirasvit\Core\Service\CompatibilityService;
use Mirasvit\LayeredNavigation\Model\Config;
use Mirasvit\LayeredNavigation\Model\Config\FilterClearBlockConfig;
use Mirasvit\LayeredNavigation\Model\Config\ConfigTrait;
use Mirasvit\LayeredNavigation\Service\FilterDataService;

/**
 * Category filter
 */
class Category extends AbstractFilter
{
    use ConfigTrait;

    const ATTRIBUTE                   = 'category_ids';
    const STORE                       = 'store_id';
    const CATEGORY                    = 'category';
    const CATEGORY_PAGE               = 'catalog_category_view';
    const BRAND_PAGE                  = 'brand_brand_view';
    const ALL_PRODUCTS_PAGE           = 'all_products_page_index_index';
    const CATEGORY_SECOND_WAY_ACTIONS = [self::BRAND_PAGE, self::ALL_PRODUCTS_PAGE];

    private $objectManager;

    private $request;

    private $layer;

    private $filterDataService;

    /**
     * @var bool
     */
    protected static $isStateAdded = [];

    public function __construct(
        ItemFactory $filterItemFactory,
        StoreManagerInterface $storeManager,
        Layer $layer,
        DataBuilder $itemDataBuilder,
        Escaper $escaper,
        CategoryFactory $categoryDataProviderFactory,
        CategoryRepositoryInterface $categoryRepository,
        LayerResolver $layerResolver,
        RequestInterface $request,
        FilterDataService $filterDataService,
        FilterClearBlockConfig $filterClearBlockConfig,
        ObjectManagerInterface $objectManager,
        array $data = []
    ) {
        parent::__construct(
            $filterItemFactory,
            $storeManager,
            $layer,
            $itemDataBuilder,
            $data
        );
        $this->escaper                = $escaper;
        $this->_requestVar            = 'cat';
        $this->dataProvider           = $categoryDataProviderFactory->create(['layer' => $this->getLayer()]);
        $this->categoryRepository     = $categoryRepository;
        $this->layer                  = $layerResolver->get();
        $this->storeManager           = $storeManager;
        $this->request                = $request;
        $this->filterDataService      = $filterDataService;
        $this->filterClearBlockConfig = $filterClearBlockConfig;
        $this->storeId                = $storeManager->getStore()->getId();
        $this->objectManager          = $objectManager;
    }


    /**
     * Apply category filter to product collection
     *
     * @param   \Magento\Framework\App\RequestInterface $request
     *
     * @return  $this
     */
    public function apply(\Magento\Framework\App\RequestInterface $request)
    {
        if (!ConfigTrait::isMultiselectEnabled()) {
            return $this->getDefaultApply($request);

        }
        $categoryId = $this->request->getParam($this->getRequestVar()) ? : $request->getParam('id');
        if (empty($categoryId)) {
            return $this;
        }
        $categoryIds       = explode(',', $categoryId);
        $categoryIds       = array_unique($categoryIds);
        $categoryIds       = array_map('intval', $categoryIds); //must be int
        $categoryIds       = array_diff($categoryIds, ['', 0, false, null]); //don't use incorrect data
        $productCollection = $this->getLayer()->getProductCollection();

        if ($request->getParam('id') != $categoryId) {
            $productCollection->addCategoryMultiFilter($categoryIds);

            $category = $this->getLayer()->getCurrentCategory();

            $child = $category->getCollection()
                ->addFieldToFilter($category->getIdFieldName(), $categoryIds)
                ->addAttributeToSelect('name');
            $this->addState(false, $categoryIds, $child);
        }

        return $this;
    }

    /**
     * Add data to state
     * @return bool
     */
    protected function addState($categoryName, $categoryId, $child = false)
    {
        $state = is_array($categoryId)
            ? $this->_requestVar . implode('_', $categoryId) : $this->_requestVar . $categoryId;
        if (isset(self::$isStateAdded[$state])) { //avoid double state adding (horizontal filters)
            return true;
        }

        if (is_array($categoryId) && $child && $this->filterClearBlockConfig->isFilterClearBlockInOneRow()) {
            $labels = [];
            foreach ($categoryId as $categoryIdValue) {
                if ($currentCategory = $child->getItemById($categoryIdValue)) {
                    $labels[] = $currentCategory->getName();
                }
            }
            $this->getLayer()->getState()->addFilter(
                $this->_createItem(implode(', ', $labels),
                    $categoryId
                )
            );
        } elseif (is_array($categoryId) && $child) {
            foreach ($categoryId as $categoryIdValue) {
                if ($currentCategory = $child->getItemById($categoryIdValue)) {
                    $this->getLayer()->getState()->addFilter(
                        $this->_createItem($currentCategory->getName(),
                            $categoryIdValue
                        )
                    );
                }
            }
        } else {
            $this->getLayer()->getState()->addFilter(
                $this->_createItem($categoryName,
                    $categoryId
                )
            );
        }

        self::$isStateAdded[$state] = true;

        return true;
    }

    /**
     * Get filter name
     * @return string
     */
    public function getName()
    {
        return __('Category');
    }

    /**
     * Get data array for building category filter items
     * @return array
     */
    protected function _getItemsData()
    {
        $optionsFacetedData = $this->getFacetedData();
        $category           = $this->dataProvider->getCategory();

        if ($category->getIsActive()) {
            $categoryData = $this->getPreparedCategoryData($optionsFacetedData);
            foreach ($categoryData as $data) {
                $this->itemDataBuilder->addItemData(
                    ['label' => $data['category_name'], 'data' => $data],
                    $data['category_id'],
                    $data['count']
                );
            }
        }

        $itemsData = $this->itemDataBuilder->build();

        if (count($itemsData) == 1) {
            $collectionSize = $this->getLayer()->getProductCollection()->getSize();
            if (!$this->isOptionReducesResults($itemsData[0]['count'], $collectionSize)) {
                $itemsData = [];
            }
        }

        return $itemsData;
    }

    private function prepareCategories($optionsFacetedData)
    {
        $categories = [];
        foreach ($optionsFacetedData as $key => $value) {
            $categories[] = $this->categoryRepository->get($key);
        }

        return $categories;
    }

    /**
     * Get prepared category data to build category filters
     * for following actions 'brand_brand_view', 'all_products_page_index_index'
     * @return array
     */
    protected function getPreparedCategoryData($optionsFacetedData)
    {
        if (!$optionsFacetedData) {
            return [];
        }

        $flatCategoryData  = [];
        $minLevel          = 1000;
        $parentIds         = [];
        $currentCategoryId = $this->layer->getCurrentCategory()->getId();

        foreach ($optionsFacetedData as $categoryId => $optionsFaceted) {
            $category = $this->categoryRepository->get($categoryId, $this->storeId);
            if (is_object($category) && $category->getIsActive()
                && isset($optionsFacetedData[$category->getId()])
            ) {
                $parentCategory = $category->getParentCategory();
                $parentId       = $parentCategory->getId();

                if (!in_array($parentId, array_keys($optionsFacetedData))
                    && $parentCategory->getLevel() > 1 && $parentCategory->getIsActive()
                    && $currentCategoryId != $parentId) {

                    $minLevel                    = ($minLevel > $parentCategory->getLevel()) ? $parentCategory->getLevel() : $minLevel;
                    $parentIds[]                 = $parentCategory->getParentCategory()->getId();
                    $flatCategoryData[$parentId] = [
                        'category_name' => $this->escaper->escapeHtml($parentCategory->getName()),
                        'category_id'   => $parentCategory->getId(),
                        'parent_id'     => $parentCategory->getParentCategory()->getId(),
                        'count'         => 0,
                        'level'         => $parentCategory->getLevel(),
                    ];
                }

                $minLevel                      = ($minLevel > $category->getLevel()) ? $category->getLevel() : $minLevel;
                $parentIds[]                   = $parentId;
                $flatCategoryData[$categoryId] = [
                    'category_name' => $this->escaper->escapeHtml($category->getName()),
                    'category_id'   => $categoryId,
                    'parent_id'     => $parentId,
                    'count'         => $optionsFacetedData[$categoryId]['count'],
                    'level'         => $category->getLevel(),
                ];
            }
        }

        $categoryData         = $this->sortCategories('category_id', 'parent_id', $flatCategoryData, min($parentIds));
        $fullActionName       = $this->request->getFullActionName();
        $categoryDataPrepared = null;

        if ($fullActionName === self::BRAND_PAGE && CompatibilityService::hasModule('Mirasvit_Brand')) {
            if ($this->objectManager->get(\Mirasvit\Brand\Model\Config\GeneralConfig::class)->isShowAllCategories()) {
                $categoryDataPrepared = $categoryData;
            } else {
                $categoryDataPrepared = [];
            }
        }

        if ($fullActionName === self::ALL_PRODUCTS_PAGE && CompatibilityService::hasModule('Mirasvit_AllProducts')) {
            if ($this->objectManager->get(\Mirasvit\AllProducts\Api\Config\ConfigInterface::class)->isShowAllCategories()) {
                $categoryDataPrepared = $categoryData;
            } else {
                $categoryDataPrepared = [];
            }
        }

        if (ConfigTrait::isShowNestedCategories() && $fullActionName === self::CATEGORY_PAGE) {
            $categoryDataPrepared = $categoryData;
        }

        if ($categoryDataPrepared === null) {
            $categoryDataPrepared = array_map(function ($category) use ($minLevel) {
                if ($category['level'] == $minLevel) {
                    return $category;
                }
            }, $categoryData);
            $categoryDataPrepared = array_filter($categoryDataPrepared);
        }

        foreach ($categoryDataPrepared as $key => $category) {
            $categoryDataPrepared[$key]['level'] = $category['level'] - $minLevel;
            unset($categoryDataPrepared[$key]['depth']);
        }

        return $categoryDataPrepared;
    }

    private function sortCategories($idField, $parentField, $flatCategoryData, $parentID = 0, &$result = [], &$depth = 0)
    {
        foreach ($flatCategoryData as $key => $categoryData) {
            if ($categoryData[$parentField] == $parentID) {
                $categoryData['depth'] = $depth;
                array_push($result, $categoryData);
                unset($flatCategoryData[$key]);
                $oldParent = $parentID;
                $parentID  = $categoryData[$idField];
                $depth++;
                $this->sortCategories($idField, $parentField, $flatCategoryData, $parentID, $result, $depth);
                $parentID = $oldParent;
                $depth--;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getFacetedData()
    {
        $productCollection = $this->getLayer()->getProductCollection();

        $startCategoryForCountBucket = $this->layer->getCurrentCategory();

        /** @var \Mirasvit\LayeredNavigation\Model\Request\Builder $requestBuilder */
        $requestBuilder = clone $productCollection->getCloneRequestBuilder();
        $requestBuilder->removePlaceholder(self::ATTRIBUTE);
        $requestBuilder->removePlaceholder(self::STORE);
        $requestBuilder->bind(self::STORE, $this->getStoreId());
        $requestBuilder->bind(self::ATTRIBUTE, $startCategoryForCountBucket->getId());

        $searchRequest = $requestBuilder->create();

        $optionsFacetedData = $this->filterDataService->getFilterBucketData($searchRequest, self::CATEGORY);

        return $optionsFacetedData;
    }

    /**
     * Apply category filter to product collection
     *
     * @param   \Magento\Framework\App\RequestInterface $request
     *
     * @return  $this
     */
    protected function getDefaultApply($request)
    {
        if ($request->getRouteName() ==Config::IS_CATALOG_SEARCH) {
            return $this->getCatalogSearchApply($request);
        } else {
            return $this->getCatalogApply($request);
        }
    }

    /**
     * Apply category filter to layer
     *
     * @param   \Magento\Framework\App\RequestInterface $request
     *
     * @return  $this
     */
    private function getCatalogApply(\Magento\Framework\App\RequestInterface $request)
    {
        $categoryId = (int)$request->getParam($this->getRequestVar());
        if (!$categoryId) {
            return $this;
        }

        $this->dataProvider->setCategoryId($categoryId);

        if ($this->dataProvider->isValid()) {
            $category = $this->dataProvider->getCategory();
            $this->getLayer()->getProductCollection()->addCategoryFilter($category);
            $this->addState($category->getName(), $categoryId);
        }

        return $this;
    }

    /**
     * Apply category filter to product collection
     *
     * @param   \Magento\Framework\App\RequestInterface $request
     *
     * @return  $this
     */
    private function getCatalogSearchApply(\Magento\Framework\App\RequestInterface $request)
    {
        $categoryId = $request->getParam($this->_requestVar) ? : $request->getParam('id');
        if (empty($categoryId)) {
            return $this;
        }

        $this->dataProvider->setCategoryId($categoryId);

        $category = $this->dataProvider->getCategory();

        $this->getLayer()->getProductCollection()->addCategoryFilter($category);

        if ($request->getParam('id') != $category->getId() && $this->dataProvider->isValid()) {
            $this->addState($category->getName(), $categoryId);
        }

        return $this;
    }
}
