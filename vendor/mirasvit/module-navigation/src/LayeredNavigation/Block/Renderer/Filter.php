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



namespace Mirasvit\LayeredNavigation\Block\Renderer;

use Magento\Catalog\Model\Layer\Filter\FilterInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\LayeredNavigation\Block\Navigation\FilterRenderer;
use Mirasvit\LayeredNavigation\Model\Config;
use Mirasvit\LayeredNavigation\Model\Config\AdditionalFiltersConfig;
use Mirasvit\LayeredNavigation\Model\Config\ConfigTrait;
use Mirasvit\LayeredNavigation\Model\Config\HighlightConfig;
use Mirasvit\LayeredNavigation\Model\Config\LinksLimitConfig;
use Mirasvit\LayeredNavigation\Model\Config\SliderConfig;
use Mirasvit\LayeredNavigation\Repository\AttributeConfigRepository;
use Mirasvit\LayeredNavigation\Service\FilterService;
use Mirasvit\LayeredNavigation\Service\SliderService;

class Filter extends FilterRenderer
{
    use ConfigTrait;

    /**
     * @var FilterInterface
     */
    protected $filter;

    /**
     * @var FilterInterface
     */
    protected static $sliderOptions;

    private          $attributeConfigRepository;

    private          $sliderConfig;

    private          $filterService;

    private          $storeManager;

    private          $registry;

    private          $objectManager;

    private          $request;

    private          $sliderService;

    private          $highlightConfig;

    private          $linksLimitConfig;

    private          $config;

    private          $storeId;

    public function __construct(
        Context $context,
        FilterService $filterService,
        AttributeConfigRepository $attributeConfigRepository,
        Registry $registry,
        ObjectManagerInterface $objectManager,
        SliderService $sliderService,
        SliderConfig $sliderConfig,
        HighlightConfig $highlightConfig,
        LinksLimitConfig $linksLimitConfig,
        Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->filterService             = $filterService;
        $this->attributeConfigRepository = $attributeConfigRepository;
        $this->storeManager              = $context->getStoreManager();
        $this->registry                  = $registry;
        $this->objectManager             = $objectManager;
        $this->request                   = $context->getRequest();
        $this->sliderService             = $sliderService;
        $this->sliderConfig              = $sliderConfig;
        $this->highlightConfig           = $highlightConfig;
        $this->linksLimitConfig          = $linksLimitConfig;
        $this->config                    = $config;
        $this->storeId                   = $this->storeManager->getStore()->getStoreId();
    }

    /**
     * @param FilterInterface $filter
     *
     * @return string
     */
    public function render(FilterInterface $filter)
    {
        $this->_viewVars = []; // reset view vars for current filter

        $template = $this->getFilterTemplate($filter->getRequestVar());
        $this->setTemplate($template);
        $this->filter  = $filter;
        $attributeCode = $this->getAttributeCode($this->filter);
        $this->assign('filter', $filter);
        $this->assign('attributeCode', $attributeCode);
        if ($this->sliderConfig->isSliderEnabled($this->storeId, $filter->getRequestVar())) {
            $sliderData = $this->filter->getSliderData($this->getSliderUrl(), get_class($this->filter));
            $this->assign('sliderData', $sliderData);
        }

        $html = parent::render($this->filter);


        return $html;
    }

    /**
     * @param string $requestVar
     *
     * @return string
     */
    private function getFilterTemplate($requestVar)
    {
        if ($requestVar == AdditionalFiltersConfig::RATING_FILTER_FRONT_PARAM) {
            $this->assign('ratingFilterData',
                $this->registry->registry(AdditionalFiltersConfig::RATING_FILTER_DATA)
            );
        }

        $template = 'layer/filter.phtml';

        if ($this->sliderService->isSliderEnabled($requestVar)) {
            $template = 'layer/slider.phtml';
        }

        return $template;
    }


    /**
     * @param \Magento\Catalog\Model\Layer\Filter\Item $filterItem
     * @param bool                                     $multiselect
     *
     * @return bool
     */
    public function isFilterChecked($filterItem, $multiselect = false)
    {
        return $this->filterService->isFilterChecked($filterItem, $multiselect);
    }


    /**
     * @return FilterInterface
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param FilterInterface $filter
     *
     * @return string
     */
    public function getAttributeCode($filter)
    {
        return $this->filterService->getAttributeCode($filter);
    }

    /**
     * @param FilterInterface $filter
     *
     * @return string
     */
    public function getFilterUniqueValue($filter)
    {
        return $this->filterService->getFilterUniqueValue($filter);
    }

    /**
     * @return bool
     */
    public function isStylizedCheckbox()
    {
        $isStylizedCheckbox = true;
        $displayOption      = $this->config->getMultiselectDisplayOptions();
        if ($displayOption === Config\Source\MultiselectDisplayOptions::OPTION_DEFAULT
            || $displayOption === Config\Source\MultiselectDisplayOptions::OPTION_SIMPLE_CHECKBOX) {
            $isStylizedCheckbox = false;
        }

        return $isStylizedCheckbox;
    }

    /**
     * @return string
     */
    public function getCheckboxClass()
    {
        $class = $this->config->getMultiselectDisplayOptions();

        return $class;
    }

    /**
     * @return string
     */
    public function getStyle()
    {
        if ($this->config->getMultiselectDisplayOptions() == Config\Source\MultiselectDisplayOptions::OPTION_DEFAULT) {
            $style = 'display: none;';
        } else {
            $style = '';
        }

        return $style;
    }

    /**
     * @return array
     */
    public function getImageSettings()
    {
        $collection = $this->attributeConfigRepository->getCollection();

        $imageSettings = [];

        foreach ($collection as $attrConfig) {
            foreach ($attrConfig->getOptionsConfig() as $optionConfig) {
                $optionId = $optionConfig->getOptionId();

                if ($optionConfig->getImagePath()) {
                    $imageSettings[$attrConfig->getAttributeCode()][$optionId]['url'] = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
                        . 'tmp/catalog/product/' . $optionConfig->getImagePath();
                }
                if ($optionConfig->isFullImageWidth()) {
                    $imageSettings[$attrConfig->getAttributeCode()][$optionId]['is_whole'] = 1;
                }

                $imageSettings[$attrConfig->getAttributeCode()][$optionId]['text'] = $optionConfig->getLabel();
            }
        }

        return $imageSettings;
    }

    /**
     * @param string $imageSettings
     * @param string $valueString
     * @param string $requestVar
     * @param string $label
     *
     * @return string
     */
    public function getFilterLabel($imageSettings, $valueString, $requestVar, $label)
    {
        if ($imageSettings
            && isset($imageSettings[$requestVar][$valueString]['url'])
            && isset($imageSettings[$requestVar][$valueString]['is_whole'])) {
            return '';
        }

        if ($imageSettings
            && isset($imageSettings[$requestVar][$valueString]['text'])
            && $imageSettings[$requestVar][$valueString]['text']) {
            return $imageSettings[$requestVar][$valueString]['text'];
        }

        return $label;
    }

    /**
     * @param string $label
     *
     * @return string
     */
    public function getImageStyle($label)
    {
        if (!$label) {
            return 'width: 100%';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getShowMoreLinksCount()
    {
        return $this->linksLimitConfig->getShowMoreLinks($this->storeId);
    }

    /**
     * @return string
     */
    public function getLinksLimitDisplay()
    {
        return $this->linksLimitConfig->getLinksLimitDisplay($this->storeId);
    }

    /**
     * @return string
     */
    public function getScrollStyle($filterItemsCount)
    {
        $scrollStyle = '';
        if ($this->getShowMoreLinksCount()
            && $this->getLinksLimitDisplay() == Config\Source\LinksLimitWayDisplayOptions::OPTION_SCROLL
            && $filterItemsCount > $this->getShowMoreLinksCount()) {
            $scrollHeight = ($this->linksLimitConfig->getScrollHeight($this->storeId))
                ? : $this->getShowMoreLinksCount() * 33;
            $scrollStyle  = 'style="overflow-x: hidden; max-height:' . $scrollHeight . 'px"';
        }

        return $scrollStyle;
    }

    /**
     * @return bool
     */
    public function isLinkShowHide()
    {
        if ($this->getLinksLimitDisplay() == Config\Source\LinksLimitWayDisplayOptions::OPTION_LINK_SHOW_HIDE) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getFilterLessText()
    {
        return $this->linksLimitConfig->getLessText($this->storeId);
    }

    /**
     * @return string
     */
    public function getFilterMoreText()
    {
        return $this->linksLimitConfig->getMoreText($this->storeId);
    }

    /**
     * @return string
     */
    public function isNavMultiselectEnabled()
    {
        return ConfigTrait::isMultiselectEnabled();
    }

    /**
     * @return string
     */
    public function isNavAjaxEnabled()
    {
        return $this->isAjaxEnabled();
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->storeManager->getStore()->getCurrentCurrency()->getCurrencySymbol();
    }

    /**
     * @return string
     */
    public function getSliderUrl()
    {
        return $this->sliderService->getSliderUrl($this->filter, $this->getSliderParamTemplate());
    }

    /**
     * @return string
     */
    public function getSliderParamTemplate()
    {
        return $this->sliderService->getParamTemplate($this->filter);
    }

    /**
     * @return string
     */
    public function isSeoFilterEnabled()
    {
        return $this->config->isSeoFiltersEnabled();
    }

    /**
     * @return string
     */
    public function isEnabledLinkHighlight()
    {
        return $this->highlightConfig->isEnabledLinkHighlight($this->storeId);
    }
}
