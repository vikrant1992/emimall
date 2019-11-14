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



namespace Mirasvit\LayeredNavigation\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Mirasvit\LayeredNavigation\Model\Config\Source\HorizontalFilterOptions;

class HorizontalFiltersConfig
{
    const STATE_BLOCK_NAME            = 'catalog.navigation.state';
    const STATE_SEARCH_BLOCK_NAME     = 'catalogsearch.navigation.state';
    const STATE_HORIZONTAL_BLOCK_NAME = 'm.catalog.navigation.horizontal.state';
    const FILTER_BLOCK_NAME           = 'm.catalog.navigation.horizontal.renderer';

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getHorizontalFilters($store = null)
    {
        $horizontalFilters = $this->scopeConfig->getValue(
            'layerednavigation/horizontal_filters/horizontal_filters_select',
            ScopeInterface::SCOPE_STORE,
            $store
        );

        if (!$horizontalFilters) {
            return $horizontalFilters;
        }

        if (strpos($horizontalFilters, HorizontalFilterOptions::ALL_FILTERED_ATTRIBUTES) !== false) {
            return HorizontalFilterOptions::ALL_FILTERED_ATTRIBUTES;
        }

        $horizontalFiltersArray = explode(',', $horizontalFilters);

        $horizontalFiltersArrayPrepared = array_map(
            function ($value) {
                return strtok($value, HorizontalFilterOptions::HORIZONTAL_FILTER_CONFIG_SEPARATOR);
            },
            $horizontalFiltersArray
        );

        $horizontalFiltersArrayPrepared = array_unique($horizontalFiltersArrayPrepared);

        return $horizontalFiltersArrayPrepared;
    }

    /**
     * {@inheritdoc}
     */
    public function getHideHorizontalFiltersValue($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/horizontal_filters/horizontal_filters_hide',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isUseCatalogLeftnavHorisontalNavigation($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/horizontal_filters/is_use_catalog_leftnav_horisontal_navigation',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
