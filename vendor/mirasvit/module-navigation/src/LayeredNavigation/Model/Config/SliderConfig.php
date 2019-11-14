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

class SliderConfig
{
    const SLIDER_FILTER_CONFIG_SEPARATOR = '|';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param null|int|\Magento\Store\Model\Store $store
     *
     * @return int
     */
    public function getSliderOptions($store = null)
    {
        $slider = $this->scopeConfig->getValue(
            'layerednavigation/slider/slider_options',
            ScopeInterface::SCOPE_STORE,
            $store
        );

        if (!$slider) {
            return $slider;
        }

        $sliderArray = explode(',', $slider);

        $sliderArrayPrepared = array_map(
            function ($value) {
                return strtok($value, self::SLIDER_FILTER_CONFIG_SEPARATOR);
            },
            $sliderArray
        );

        $sliderArrayPrepared = array_unique($sliderArrayPrepared);

        return $sliderArrayPrepared;
    }

    /**
     * @param null|int|\Magento\Store\Model\Store $store
     *
     * @return bool
     */
    public function isSliderEnabled($store = null, $attributeCode)
    {
        $sliderOptions = $this->getSliderOptions($store);

        if (is_array($sliderOptions)
            && array_search($attributeCode, $sliderOptions) !== false) {
            return true;
        }

        return false;
    }

    /**
     * @param null|int|\Magento\Store\Model\Store $store
     *
     * @return int
     */
    public function getSliderHandleColor($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/slider/slider_handle_color',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * @param null|int|\Magento\Store\Model\Store $store
     *
     * @return int
     */
    public function getSliderHandleBorderColor($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/slider/slider_handle_border_color',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * @param null|int|\Magento\Store\Model\Store $store
     *
     * @return int
     */
    public function getSliderConnectColor($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/slider/slider_connect_color',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * @param null|int|\Magento\Store\Model\Store $store
     *
     * @return int
     */
    public function getSliderTextColor($store = null)
    {
        return $this->scopeConfig->getValue(
            'layerednavigation/slider/slider_text_color',
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
