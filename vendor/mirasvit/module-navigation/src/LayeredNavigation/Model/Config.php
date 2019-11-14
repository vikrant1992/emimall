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



namespace Mirasvit\LayeredNavigation\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const AJAX_SUFFIX                    = 'mAjax';
    const AJAX_PRODUCT_LIST_WRAPPER_ID   = 'm-navigation-product-list-wrapper';
    const AJAX_STATE_WRAPPER_ID          = 'm-navigation-state-wrapper';
    const AJAX_STATE_WRAPPER_CLASS       = 'm-navigation-state';
    const AJAX_STATE_WRAPPER_INPUT_CLASS = 'm-navigation-state-input';
    const AJAX_SWATCH_WRAPPER_CLASS      = 'm-navigation-swatch';

    const NAV_IMAGE_REG_PRODUCT_DATA = 'm-navigation-register-product-data';

    const NAV_REPLACER_TAG = '<div id="m-navigation-replacer"></div>'; //use for filter opener

    const IS_CATALOG_SEARCH     = 'catalogsearch';
    const IS_PRICE_SLIDER_ADDED = 'm__is_price_slider_added';

    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function isSeoFiltersEnabled()
    {
        return $this->scopeConfig->getValue('seofilter/seofilter/is_seofilter_enabled', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isAjaxEnabled()
    {
        return (int)$this->scopeConfig->getValue('layerednavigation/general/is_ajax_enabled', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isShowNestedCategories()
    {
        return (int)$this->scopeConfig->getValue('layerednavigation/general/is_show_nested_categories', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isMultiselectEnabled()
    {
        return (int)$this->scopeConfig->getValue('layerednavigation/general/is_multiselect_enabled', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function getMultiselectDisplayOptions()
    {
        return $this->scopeConfig->getValue('layerednavigation/general/multiselect_display_options', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function getDisplayOptionsBackgroundColor()
    {
        return $this->scopeConfig->getValue('layerednavigation/general/display_options_background_color', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function getDisplayOptionsBorderColor()
    {
        return $this->scopeConfig->getValue('layerednavigation/general/display_options_border_color', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function getDisplayOptionsCheckedLabelColor()
    {
        return $this->scopeConfig->getValue('layerednavigation/general/display_options_checked_label_color', ScopeInterface::SCOPE_STORE);
    }

    /**@return bool
     */
    public function isShowOpenedFilters()
    {
        return $this->scopeConfig->getValue('layerednavigation/general/is_show_opened_filters', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isCorrectElasticFilterCount()
    {
        return $this->scopeConfig->getValue('layerednavigation/general/is_correct_elastic_filter_count', ScopeInterface::SCOPE_STORE);
    }

}
