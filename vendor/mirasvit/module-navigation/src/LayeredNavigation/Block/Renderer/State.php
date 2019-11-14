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

use Magento\Catalog\Model\Layer\Filter\Item;
use Magento\Catalog\Model\Layer\Resolver as LayerResolver;
use Magento\Framework\View\Element\Template\Context;
use Magento\LayeredNavigation\Block\Navigation\State as NavigationState;
use Mirasvit\LayeredNavigation\Model\Config\ConfigTrait;
use Mirasvit\LayeredNavigation\Model\Config\FilterClearBlockConfig;
use Mirasvit\LayeredNavigation\Model\Config\HorizontalFiltersConfig;

class State extends NavigationState
{
    use ConfigTrait;

    /**
     * @var string
     */
    protected $_template = 'layer/state.phtml';

    private   $storeId;

    private   $horizontalFiltersConfig;

    private   $filterClearBlockConfig;

    public function __construct(
        HorizontalFiltersConfig $horizontalFiltersConfig,
        Context $context,
        LayerResolver $layerResolver,
        FilterClearBlockConfig $filterClearBlockConfig,
        array $data = []
    ) {
        $this->storeId                 = $context->getStoreManager()->getStore()->getStoreId();
        $this->horizontalFiltersConfig = $horizontalFiltersConfig;
        $this->filterClearBlockConfig  = $filterClearBlockConfig;

        parent::__construct($context, $layerResolver, $data);
    }

    /**
     * Retrieve active filters
     * @return Item[]
     */
    public function getActiveFilters()
    {
        $nameInLayout = $this->getNameInLayout();

        if (($nameInLayout == HorizontalFiltersConfig::STATE_HORIZONTAL_BLOCK_NAME)
            && !$this->filterClearBlockConfig->isHorizontalFiltersClearPanelEnabled($this->storeId)) {
            return [];
        }

        if (($nameInLayout == HorizontalFiltersConfig::STATE_BLOCK_NAME
                || $nameInLayout == HorizontalFiltersConfig::STATE_SEARCH_BLOCK_NAME)
            && $this->filterClearBlockConfig->isHorizontalFiltersClearPanelEnabled($this->storeId)) {
            return [];
        }

        $filters = $this->getLayer()->getState()->getFilters();

        if (!is_array($filters)) {
            $filters = [];
        }

        return $filters;
    }

    public function isHorizontalFilter()
    {
        $nameInLayout = $this->getNameInLayout();
        if ($nameInLayout == HorizontalFiltersConfig::STATE_HORIZONTAL_BLOCK_NAME) {
            return true;
        }

        return false;
    }

    public function getPreparedValue($requestVar, $value)
    {
        if ($requestVar != 'price' || $this->isMultiselectEnabled()) {
            return $value;
        }

        return str_replace(',', '-', $value);
    }
}
