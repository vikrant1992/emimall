<?php

/**
 * BFL Cybage_Productdetail
 *
 * @category   Cybage_Productdetail Block
 * @package    BFL Cybage_Productdetail
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Productdetail\Block;

/**
 * Class Attributes
 */
class Specification extends \Magento\Catalog\Block\Product\View
{

    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory
     */
    protected $groupCollectionFactory;

    /**
     *
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Catalog\Helper\Product $productHelper
     * @param \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory $groupCollectionFactory
     * @param \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSet
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory $groupCollectionFactory,
        \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSet,
        array $data = []
    ) {
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
        $this->groupCollectionFactory = $groupCollectionFactory;
        $this->attributeSet = $attributeSet;
    }

    /**
     * getProductSpecification
     * @return type array
     */
    public function getProductSpecification()
    {
        $data = [];
        $ignoreAttributeCodes = ['emi_starting_at', 'spec_score','price'];
        $product = $this->getProduct();
        $attributeSetId = $product->getAttributeSetId();
        $groupCollection = $this->groupCollectionFactory->create()
            ->setAttributeSetFilter($attributeSetId)
            ->setSortOrder()
            ->load();
        foreach ($groupCollection as $group) {
            $attributes = $product->getAttributes($group->getId(), true);
            foreach ($attributes as $key => $attribute) {
                if ($attribute->getIsVisibleOnFront() &&
                    $attribute->getFrontend()->getValue($product) != "" &&
                    $attribute->getFrontend()->getValue($product) != "Non") {
                    if (!in_array($attribute->getAttributeCode(), $ignoreAttributeCodes)) {
                        $data[$group->getData('attribute_group_name')][$attribute->getFrontend()->getLabel()] = $attribute->getFrontend()->getValue($product);
                    }
                }
            }
        }
        return $data;
    }
}
