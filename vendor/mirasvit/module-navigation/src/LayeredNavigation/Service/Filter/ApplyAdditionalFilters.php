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



namespace Mirasvit\LayeredNavigation\Service\Filter;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Search\Request\Builder;
use Magento\Framework\Search\RequestInterface as SearchRequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mirasvit\LayeredNavigation\Model\Config\AdditionalFiltersConfig;
use Mirasvit\LayeredNavigation\Service\ElasticsearchService;

class ApplyAdditionalFilters
{
    private $elasticSearchService;

    /**
     * @var int
     */
    private $storeId;

    /**
     * @var AdditionalFiltersConfig
     */
    private $additionalFiltersConfig;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        ElasticsearchService $elasticSearchService,
        AdditionalFiltersConfig $additionalFiltersConfig,
        StoreManagerInterface $storeManager,
        RequestInterface $request
    ) {
        $this->storeId                 = $storeManager->getStore()->getId();
        $this->additionalFiltersConfig = $additionalFiltersConfig;
        $this->request                 = $request;
        $this->elasticSearchService    = $elasticSearchService;
    }

    /**
     * Apply additional filters when Elastic Search Engine is used.
     *
     * @param Builder $builder
     *
     * @return SearchRequestInterface $request
     */
    public function apply(Builder $builder)
    {
        if ($this->additionalFiltersConfig->isOnSaleFilterEnabled($this->storeId)
            && $this->elasticSearchService->isElasticEngineUsed()
        ) {
            $value = $this->request->getParam(AdditionalFiltersConfig::ON_SALE_FILTER_FRONT_PARAM);
            if ($value) {
                $builder->bind(AdditionalFiltersConfig::ON_SALE_FILTER, 1);
            }
        }

        return $builder;
    }
}
