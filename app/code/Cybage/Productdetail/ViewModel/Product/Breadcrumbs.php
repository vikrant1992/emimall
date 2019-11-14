<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cybage\Productdetail\ViewModel\Product;

use Magento\Catalog\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Escaper;

/**
 * Product breadcrumbs view model.
 */
class Breadcrumbs extends \Magento\Catalog\ViewModel\Product\Breadcrumbs implements ArgumentInterface
{
    /**
     * Catalog data.
     *
     * @var Data
     */
    private $catalogData;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @param Data $catalogData
     * @param ScopeConfigInterface $scopeConfig
     * @param Json|null $json
     * @param Escaper|null $escaper
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        Data $catalogData,
        ScopeConfigInterface $scopeConfig,
        Json $json = null,
        Escaper $escaper = null
    ) {
        $this->catalogData = $catalogData;
        $this->scopeConfig = $scopeConfig;
        $this->escaper = $escaper ?: ObjectManager::getInstance()->get(Escaper::class);
        parent::__construct($this->catalogData, $this->scopeConfig, null, $this->escaper);
    }
    /**
     * Returns product url.
     *
     * @return string
     */
    public function getProductUrl()
    {
        return $this->catalogData->getProduct() !== null
            ? $this->catalogData->getProduct()->getProductUrl()
            : '';
    }
}
