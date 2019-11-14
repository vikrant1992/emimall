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



namespace Mirasvit\LayeredNavigation\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mirasvit\LayeredNavigation\Model\Config;
use Mirasvit\LayeredNavigation\Model\Config\ConfigTrait;
use Mirasvit\LayeredNavigation\Model\Config\FilterClearBlockConfig;
use Mirasvit\LayeredNavigation\Model\Config\HorizontalFiltersConfig;
use Mirasvit\LayeredNavigation\Service\FilterService;

class Ajax extends Template
{
    use ConfigTrait;

    private $filterService;

    private $config;

    private $filterClearBlockConfig;

    private $horizontalFiltersConfig;

    private $storeId;

    public function __construct(
        Context $context,
        FilterService $filterService,
        Config $config,
        FilterClearBlockConfig $filterClearBlockConfig,
        HorizontalFiltersConfig $horizontalFiltersConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->filterService           = $filterService;
        $this->config                  = $config;
        $this->filterClearBlockConfig  = $filterClearBlockConfig;
        $this->horizontalFiltersConfig = $horizontalFiltersConfig;
        $this->storeId                 = $context->getStoreManager()->getStore()->getStoreId();
    }

    public function getJsonConfig()
    {
        return [
            'body.page-with-filter, body.catalogsearch-result-index' => [
                'Mirasvit_LayeredNavigation/js/navigation' => [
                    'cleanUrl'                   => $this->getCleanUrl(),
                    'overlayUrl'                 => $this->getOverlayUrl(),
                    'isSeoFilterEnabled'         => $this->isSeoFilterEnabled(),
                    'isFilterClearBlockInOneRow' => $this->isFilterClearBlockInOneRow(),
                    'isHorizontalByDefault'      => $this->isUseCatalogLeftnavHorisontalNavigation(),
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    private function getCleanUrl()
    {
        $activeFilters = [];

        foreach ($this->filterService->getActiveFilters() as $item) {
            $filter = $item->getFilter();

            $activeFilters[$filter->getRequestVar()] = $filter->getCleanValue();
        }

        $params['_current']     = true;
        $params['_use_rewrite'] = true;
        $params['_query']       = array_merge($activeFilters,
            [Config::AJAX_SUFFIX => null]
        );
        $params['_escape']      = true;

        $url = $this->_urlBuilder->getUrl('*/*/*', $params);
        $url = str_replace('&amp;', '&', $url);

        return $url;
    }

    /**
     * @return string
     */
    private function getOverlayUrl()
    {
        return $this->getViewFileUrl('Mirasvit_LayeredNavigation::images/ajax_loading.gif');
    }

    /**
     * @return string
     */
    private function isSeoFilterEnabled()
    {
        return $this->config->isSeoFiltersEnabled();
    }

    /**
     * @return int
     */
    private function isFilterClearBlockInOneRow()
    {
        return $this->filterClearBlockConfig->isFilterClearBlockInOneRow();
    }

    /**
     * @return int
     */
    private function isUseCatalogLeftnavHorisontalNavigation()
    {
        return $this->horizontalFiltersConfig->isUseCatalogLeftnavHorisontalNavigation($this->storeId);
    }
}
