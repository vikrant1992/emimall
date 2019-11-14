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



namespace Mirasvit\LayeredNavigation\Service;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mirasvit\LayeredNavigation\Model\Config;
use Mirasvit\LayeredNavigation\Model\Config\SliderConfig;
use Mirasvit\SeoFilter\Model\Config as SeoFilterConfig;
use Mirasvit\SeoFilter\Service\RewriteService;
use Mirasvit\SeoFilter\Service\UrlService as SeoUrlService;

class SliderService
{
    const MATCH_PREFIX            = 'slider_match_prefix_';
    const SLIDER_DATA             = 'sliderdata';
    const SLIDER_PARAM_TEMPLATE
                                  = 'm_ln_'
        . self::SLIDER_REPLACE_VARIABLE
        . '_slider_from-m_ln_'
        . self::SLIDER_REPLACE_VARIABLE
        . '_slider_to';
    const SLIDER_REPLACE_VARIABLE = '[]';

    /**
     * @var null|array
     */
    protected static $sliderOptions;

    private          $config;

    public function __construct(
        SliderConfig $sliderConfig,
        RequestInterface $request,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        Config $config,
        SeoUrlService $urlHelper,
        RewriteService $rewrite
    ) {
        $this->sliderConfig = $sliderConfig;
        $this->request      = $request;
        $this->urlBuilder   = $urlBuilder;
        $this->urlHelper    = $urlHelper;
        $this->rewrite      = $rewrite;
        $this->config       = $config;
        $this->storeId      = $storeManager->getStore()->getStoreId();
    }

    /**
     * {@inheritdoc}
     */
    public function isSliderEnabled($requestVar)
    {
        if (self::$sliderOptions === null) {
            self::$sliderOptions = $this->sliderConfig->getSliderOptions($this->storeId);
        }

        if (self::$sliderOptions && in_array($requestVar, self::$sliderOptions)) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getSliderData($facetedData, $requestVar, $fromToData, $url, $class)
    {
        $sliderData = [
            'min'        => 0,
            'max'        => 0,
            'requestVar' => 0,
            'from'       => 0,
            'to'         => 0,
            'url'        => 0,
        ];

        $sliderDataKey = $this->getSliderDataKey($requestVar);

        if (!isset($facetedData[$sliderDataKey])) {
            return $sliderData;
        }

        $min  = floatval($facetedData[$sliderDataKey]['min']);
        $max  = floatval($facetedData[$sliderDataKey]['max']);
        $from = ($fromToData) ? $fromToData['from'] : $min;
        $to   = ($fromToData) ? $fromToData['to'] : $max;

        $sliderData = [
            'min'        => $min,
            'max'        => $max,
            'requestVar' => $requestVar,
            'from'       => $from,
            'to'         => $to,
            'url'        => $url,
        ];


        return $sliderData;
    }

    /**
     * {@inheritdoc}
     */
    public function getSliderUrl($filter, $template)
    {
        if ($this->config->isSeoFiltersEnabled()) {
            return $this->getSliderSeoFriendlyUrl($filter, $template);
        }

        $query = [$filter->getRequestVar() => $template];

        return $this->urlBuilder->getUrl('*/*/*',
            [
                '_current'     => true,
                '_use_rewrite' => true,
                '_query'       => $query,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getSliderSeoFriendlyUrl($filter, $template)
    {
        $activeFilters = $this->rewrite->getActiveFilters();
        $separator     = ($activeFilters) ? SeoFilterConfig::SEPARATOR_FILTERS : '/';
        $price         = $filter->getRequestVar() . SeoFilterConfig::SEPARATOR_DECIMAL . $template;
        $currentUrl    = $this->urlBuilder->getCurrentUrl();
        $suffix        = $this->urlHelper->getCategoryUrlSuffix($this->storeId);

        if (isset($activeFilters[$filter->getRequestVar()])) { //delete old param from url
            $currentUrlPrepared      = strtok($currentUrl, '?');
            $currentUrlPreparedArray = explode('/', $currentUrlPrepared);
            $priceValue              = $currentUrlPreparedArray[count($currentUrlPreparedArray) - 1];
            $priceValue              = ($suffix) ? str_replace($suffix, '', $priceValue) : $priceValue;
            $priceValueArray         = explode($filter->getRequestVar(), $priceValue);
            if (isset($priceValueArray[1])) {
                $priceValue = $filter->getRequestVar() . $priceValueArray[1];
            }
            $currentUrl = str_replace($priceValue, '', $currentUrl);
        }

        if (($suffix && $suffix !== '/') && strpos($currentUrl, $suffix) !== false) {
            $currentUrl = str_replace($suffix, $separator . $price . $suffix, $currentUrl);
        } elseif (strpos($currentUrl, '?') !== false) {
            $currentUrl = str_replace('?', $separator . $price . '?', $currentUrl);
        } else {
            $currentUrl = rtrim($currentUrl, $separator) . $separator . $price;
        }

        $currentUrl = str_replace(SeoFilterConfig::SEPARATOR_FILTERS . SeoFilterConfig::SEPARATOR_FILTERS,
            SeoFilterConfig::SEPARATOR_FILTERS,
            $currentUrl
        );
        $currentUrl = str_replace('/' . SeoFilterConfig::SEPARATOR_FILTERS, '/', $currentUrl);

        return $currentUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function getParamTemplate($filter)
    {
        $requestVar = $filter->getRequestVar();

        return str_replace(
            SliderService::SLIDER_REPLACE_VARIABLE,
            $requestVar,
            SliderService::SLIDER_PARAM_TEMPLATE
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getRegisterMatchedValue($attributeCode)
    {
        return SliderService::MATCH_PREFIX . $this->getSliderDataKey($attributeCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getSliderDataKey($attributeCode)
    {
        return SliderService::SLIDER_DATA . str_replace('_', '', $attributeCode);
    }

}