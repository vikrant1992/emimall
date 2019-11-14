<?php

/**
 * BFL Cybage_Homepage
 *
 * @category   Cybage_Homepage
 * @package    BFL Cybage_Homepage
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Homepage\Block\Product;

use Magento\Directory\Model\Currency;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\Url\EncoderInterface;

/**
 * Catalog Products List widget block
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class ProductsList extends \Cybage\CatalogProduct\Block\Product\ProductsList
{
    /**
     *
     * @var Currency
     */
    protected $currency;
    
    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Magento\Rule\Model\Condition\Sql\Builder $sqlBuilder
     * @param \Magento\CatalogWidget\Model\Rule $rule
     * @param \Magento\Widget\Helper\Conditions $conditionsHelper
     * @param \Magento\Framework\Pricing\Helper\Data $priceHelper
     * @param array $data
     * @param Json $json
     * @param LayoutFactory $layoutFactory
     * @param EncoderInterface $urlEncoder
     * @param \Magento\Catalog\Model\Product $product
     * @param Currency $currency
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Rule\Model\Condition\Sql\Builder $sqlBuilder,
        \Magento\CatalogWidget\Model\Rule $rule,
        \Magento\Widget\Helper\Conditions $conditionsHelper,
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
        array $data = [],
        Json $json = null,
        LayoutFactory $layoutFactory = null,
        EncoderInterface $urlEncoder = null,
        \Magento\Catalog\Model\Product $product,
        Currency $currency
    )
    {
        $this->currency = $currency;
        parent::__construct(
            $context,
            $productCollectionFactory,
            $catalogProductVisibility,
            $httpContext,
            $sqlBuilder,
            $rule,
            $conditionsHelper,
            $priceHelper,
            $data,
            $json,
            $layoutFactory,
            $urlEncoder,
            $product
        );
    }
    
    /**
     * Get Price Instance
     * @return \Magento\Directory\Model\Currency
     */
    public function getPriceInstance() {
        return $this->currency;
    }
}
