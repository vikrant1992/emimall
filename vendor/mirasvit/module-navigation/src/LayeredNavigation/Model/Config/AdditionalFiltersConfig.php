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
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;

class AdditionalFiltersConfig
{
    const NEW_FILTER                      = 'new_products';
    const ON_SALE_FILTER                  = 'on_sale';
    const STOCK_FILTER                    = 'stock_status';
    const IN_STOCK_FILTER                 = 1;
    const OUT_OF_STOCK_FILTER             = 2;
    const RATING_FILTER                   = 'rating_summary';
    const NEW_FILTER_FRONT_PARAM          = 'new_products';
    const ON_SALE_FILTER_FRONT_PARAM      = 'on_sale';
    const STOCK_FILTER_FRONT_PARAM        = 'stock';
    const RATING_FILTER_FRONT_PARAM       = 'rating';
    const NEW_FILTER_DEFAULT_LABEL        = 'New';
    const ON_SALE_FILTER_DEFAULT_LABEL    = 'Sale';
    const STOCK_FILTER_DEFAULT_LABEL      = 'Stock';
    const RATING_FILTER_DEFAULT_LABEL     = 'Rating';
    const RATING_FILTER_DATA              = 'm__rating_filter_data';
    const RATING_DATA
                                          = [
            5 => 100,
            4 => 80,
            3 => 60,
            2 => 40,
            1 => 20,
        ];
    const STOCK_FILTER_IN_STOCK_LABEL     = 'instock';
    const STOCK_FILTER_OUT_OF_STOCK_LABEL = 'outofstock';
    const RATING_FILTER_ONE_LABEL         = 'rating1';
    const RATING_FILTER_TWO_LABEL         = 'rating2';
    const RATING_FILTER_THREE_LABEL       = 'rating3';
    const RATING_FILTER_FOUR_LABEL        = 'rating4';
    const RATING_FILTER_FIVE_LABEL        = 'rating5';

    /**
     * @inheritdoc
     */
    public function isFilterEnabled($filter, $store = null)
    {
        $method = 'is' . $this->transformToMethod($filter) . 'FilterEnabled';
        if (!method_exists($this, $method)) {
            throw new LocalizedException(__('Filter type "%1" does not exist', $filter));
        }

        return $this->{$method}($store);
    }

    public function getFilterPosition($filter, $store = null)
    {
        $method = 'get' . $this->transformToMethod($filter) . 'FilterPosition';
        if (!method_exists($this, $method)) {
            throw new LocalizedException(__('Filter type "%1" does not exist', $filter));
        }

        return $this->{$method}($store);
    }

    /**
     * Transform given str to Upper Camel Case compatible string for use in method.
     *
     * @param $str
     *
     * @return string
     */
    private function transformToMethod($str)
    {
        return str_replace('_', '', ucwords($str, '_'));
    }

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    // New Filter

    /**
     * {@inheritdoc}
     */
    public function isNewFilterEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/is_enabled_new_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getNewFilterLabel($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/label_new_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getNewFilterPosition($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/position_new_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    // On Sale Filter

    /**
     * {@inheritdoc}
     */
    public function isOnSaleFilterEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/is_enabled_on_sale_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getOnSaleFilterLabel($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/label_on_sale_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getOnSaleFilterPosition($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/position_on_sale_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    // Stock Filter

    /**
     * {@inheritdoc}
     */
    public function isStockFilterEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/is_enabled_stock_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getStockFilterLabel($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/label_stock_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getInStockFilterLabel($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/label_in_stock_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getOutOfStockFilterLabel($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/label_out_of_stock_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getStockFilterPosition($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/position_stock_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    // Rating Filter

    /**
     * {@inheritdoc}
     */
    public function isRatingFilterEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/is_enabled_rating_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getRatingFilterLabel($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/label_rating_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getRatingFilterPosition($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/additional_filters/position_rating_filter',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
