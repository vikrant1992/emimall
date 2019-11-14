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



namespace Mirasvit\LayeredNavigation\Plugin\Frontend\Catalog\Model\Layer\Filter\Item;

use Magento\Catalog\Model\Layer\Filter\Item;
use Magento\Framework\UrlInterface;
use Magento\Theme\Block\Html\Pager as PagerBlock;
use Mirasvit\LayeredNavigation\Model\Config;
use Mirasvit\LayeredNavigation\Service\FilterService;

class AttributeUrlPlugin
{
    const DELIMITER = ',';

    private $config;

    private $filterService;

    private $pagerBlock;

    private $urlManager;

    public function __construct(
        Config $config,
        FilterService $filterService,
        UrlInterface $urlManager,
        PagerBlock $pagerBlock
    ) {
        $this->config        = $config;
        $this->filterService = $filterService;
        $this->urlManager    = $urlManager;
        $this->pagerBlock    = $pagerBlock;
    }

    /**
     * Get filter item url
     *
     * @param Item   $item
     * @param string $url
     *
     * @return string
     */
    public function afterGetUrl(Item $item, $url)
    {
        if (!$this->config->isMultiselectEnabled()) {
            return $url;
        }

        $itemValue     = $item->getData('value');
        $itemFilter    = $item->getFilter();
        $attributeCode = $itemFilter->getRequestVar();

        $params = $this->getFilterParams();

        $params[$attributeCode][$itemValue] = $itemValue;

        return $this->getUrl($params);
    }

    /**
     * Get url for remove item from filter
     *
     * @param Item   $item
     * @param string $url
     *
     * @return string
     */
    public function afterGetRemoveUrl(Item $item, $url)
    {
        if (!$this->config->isMultiselectEnabled()) {
            return $url;
        }

        $itemValue     = $item->getData('value');
        $itemValues    = is_array($itemValue) ? $itemValue : [$itemValue];
        $itemFilter    = $item->getFilter();
        $attributeCode = $itemFilter->getRequestVar();

        $params = $this->getFilterParams();

        foreach ($itemValues as $value) {
            if (isset($params[$attributeCode]) && isset($params[$attributeCode][$value])) {
                unset($params[$attributeCode][$value]);
            }
        }

        return $this->getUrl($params);
    }

    /**
     * @return array
     */
    private function getFilterParams()
    {
        $activeFilters = $this->filterService->getActiveFilters();

        $result = [];

        foreach ($activeFilters as $filter) {
            $value = $filter->getData('value');

            $values = is_array($value) ? $value : explode(self::DELIMITER, $value);

            foreach ($values as $val) {
                $result[$filter->getFilter()->getRequestVar()][$val] = $val;
            }
        }

        return $result;
    }

    /**
     * @param array $filterParams
     *
     * @return string
     */
    private function getUrl($filterParams)
    {
        foreach ($filterParams as $attrCode => $values) {
            if (count($values)) {
                $filterParams[$attrCode] = implode(self::DELIMITER, $values);
            } else {
                $filterParams[$attrCode] = null;
            }
        }

        $filterParams[$this->pagerBlock->getPageVarName()] = null;

        $url = $this->urlManager->getUrl('*/*/*', [
            '_current'     => true,
            '_use_rewrite' => true,
            '_query'       => $filterParams,
        ]);

        return $url;
    }
}