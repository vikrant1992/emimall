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
 * @package   mirasvit/module-seo-filter
 * @version   1.0.14
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\SeoFilter\Service;

use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;
use Mirasvit\SeoFilter\Api\Data\RewriteInterface;
use Mirasvit\SeoFilter\Api\Repository\RewriteRepositoryInterface;
use Mirasvit\SeoFilter\Model\Config;
use Mirasvit\SeoFilter\Model\Context;

class ParserService
{
    const DECIMAL_FILTERS = 'decimalFilters';
    const STATIC_FILTERS  = 'staticFilters';

    private $urlRewrite;

    private $urlService;

    private $rewriteRepository;

    private $context;

    public function __construct(
        UrlRewriteCollectionFactory $urlRewrite,
        RewriteRepositoryInterface $rewriteRepository,
        UrlService $urlService,
        Context $context
    ) {
        $this->urlRewrite        = $urlRewrite;
        $this->urlService        = $urlService;
        $this->rewriteRepository = $rewriteRepository;
        $this->context           = $context;
    }

    /**
     * @return false|array
     */
    public function getParams()
    {
        if ($this->isNativeRewrite()) {
            return false;
        }

        $categoryId = $this->getCategoryId();

        if (!$categoryId) {
            return false;
        }

        $filterData = $this->splitFiltersString($this->getFiltersString());

        $staticFilters  = [];
        $decimalFilters = [];

        $decimalFilters = $this->handleDecimalFilters($filterData, $decimalFilters);

        $staticFilters = $this->handleStockFilters($filterData, $staticFilters);
        $staticFilters = $this->handleRatingFilters($filterData, $staticFilters);
        $staticFilters = $this->handleSaleFilters($filterData, $staticFilters);
        $staticFilters = $this->handleNewFilters($filterData, $staticFilters);

        $rewriteCollection = $this->rewriteRepository->getCollection()
            ->addFieldToFilter(RewriteInterface::REWRITE, ['in' => $filterData])
            ->addFieldToFilter(RewriteInterface::STORE_ID, $this->context->getStoreId());

        /** @var RewriteInterface $rewrite */
        foreach ($rewriteCollection as $rewrite) {
            $attrCode = $rewrite->getAttributeCode();
            $optionId = $rewrite->getOption();

            $staticFilters[$attrCode][] = $optionId;
        }

        $params = [];

        foreach ($decimalFilters as $attr => $values) {
            $params[$attr] = implode(Config::SEPARATOR_FILTER_VALUES, $values);
        }

        foreach ($staticFilters as $attr => $values) {
            $params[$attr] = implode(Config::SEPARATOR_FILTER_VALUES, $values);
        }

        $result = [
            'category_id' => $categoryId,
            'params'      => $params,
        ];

        return $result;
    }

    /**
     * @return false|int
     */
    private function getCategoryId()
    {
        $requestString = trim($this->context->getRequest()->getPathInfo(), '/');

        $shortRequestString = substr($requestString, 0, strrpos($requestString, '/'));

        if (!$shortRequestString) {
            return false;
        }

        if ($suffix = $this->urlService->getCategoryUrlSuffix()) {
            $shortRequestString = $shortRequestString . $suffix;
        }

        /** @var \Magento\UrlRewrite\Model\UrlRewrite $item */
        $item = $this->urlRewrite->create()
            ->addFieldToFilter('entity_type', 'category')
            ->addFieldToFilter('redirect_type', 0)
            ->addFieldToFilter('store_id', $this->context->getStoreId())
            ->addFieldToFilter('request_path', $shortRequestString)
            ->getFirstItem();

        $categoryId = $item->getEntityId();

        return $categoryId;
    }

    private function isNativeRewrite()
    {
        $requestString = trim($this->context->getRequest()->getPathInfo(), '/');

        $requestPathRewrite = $this->urlRewrite->create()
            ->addFieldToFilter('entity_type', 'category')
            ->addFieldToFilter('redirect_type', 0)
            ->addFieldToFilter('store_id', $this->context->getStoreId())
            ->addFieldToFilter('request_path', $requestString);

        return $requestPathRewrite->getSize() > 0 ? true : false;
    }

    /**
     * Get filter params
     *
     * @param array  $dynamicAdditionalFilter
     * @param array  $params
     * @param string $filterFrontParam
     *
     * @return array
     */
    protected function getFilterParams($dynamicAdditionalFilter, $params, $filterFrontParam)
    {
        foreach ($dynamicAdditionalFilter as $dynamicAdditionalFilterKey => $dynamicAdditionalFilterValue) {
            if (isset($params[$filterFrontParam])) {
                $params[$filterFrontParam] .= Config::SEPARATOR_FILTER_VALUES . $dynamicAdditionalFilterValue;
            } else {
                $params[$filterFrontParam] = $dynamicAdditionalFilterValue;
            }
        }

        return $params;
    }

    private function handleStockFilters(&$filterData, $staticFilters)
    {
        $options = [
            1 => Config::LABEL_STOCK_IN,
            2 => Config::LABEL_STOCK_OUT,
        ];

        return $this->processBuiltInFilters(Config::FILTER_STOCK, $options, $filterData, $staticFilters);
    }

    private function handleRatingFilters(&$filterData, $staticFilters)
    {
        $options = [
            1 => Config::LABEL_RATING_1,
            2 => Config::LABEL_RATING_2,
            3 => Config::LABEL_RATING_3,
            4 => Config::LABEL_RATING_4,
            5 => Config::LABEL_RATING_5,
        ];

        return $this->processBuiltInFilters(Config::FILTER_RATING, $options, $filterData, $staticFilters);
    }

    private function handleSaleFilters(&$filterData, $staticFilters)
    {
        $options = [
            1 => Config::FILTER_SALE,
        ];

        return $this->processBuiltInFilters(Config::FILTER_SALE, $options, $filterData, $staticFilters);
    }

    private function handleNewFilters(&$filterData, $staticFilters)
    {
        $options = [
            1 => Config::FILTER_NEW,
        ];

        return $this->processBuiltInFilters(Config::FILTER_NEW, $options, $filterData, $staticFilters);
    }

    private function processBuiltInFilters($attrCode, $options, &$filterData, $staticFilters)
    {
        foreach ($options as $key => $label) {
            foreach ($filterData as $fKey => $value) {
                if ($value == $label) {
                    $staticFilters[$attrCode][] = $key;

                    unset($filterData[$fKey]);
                }
            }
        }

        return $staticFilters;
    }

    private function handleDecimalFilters(&$filterData, $decimalFilters)
    {
        foreach ($filterData as $key => $filterValue) {
            if (strpos($filterValue, Config::SEPARATOR_DECIMAL) !== false) {
                $exploded = explode(Config::SEPARATOR_DECIMAL, $filterValue);
                $attrCode = $exploded[0];
                unset($exploded[0]);

                $option = implode(Config::SEPARATOR_FILTERS, $exploded);

                $decimalFilters[$attrCode][] = $option;

                unset($filterData[$key]);
            }
        }

        return $decimalFilters;
    }

    /**
     * @return string
     */
    private function getFiltersString()
    {
        $uri = trim($this->context->getRequest()->getPathInfo(), '/');

        $filterString = substr($uri, strrpos($uri, '/') + 1);

        $suffix = $this->urlService->getCategoryUrlSuffix();
        if ($suffix && substr($filterString, -strlen($suffix)) === $suffix) {
            $filterString = substr($filterString, 0, -strlen($suffix));
        }

        return $filterString;
    }

    /**
     * @param string $filtersString
     *
     * @return array
     */
    private function splitFiltersString($filtersString)
    {
        $filterInfo = explode(Config::SEPARATOR_FILTERS, $filtersString);

        $filterInfo = array_diff($filterInfo, ['', null, false]);

        return $filterInfo;
    }
}