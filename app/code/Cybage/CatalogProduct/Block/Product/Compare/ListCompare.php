<?php
/**
 * BFL Cybage_CatalogProduct
 *
 * @category   Cybage_CatalogProduct Module
 * @package    BFL Cybage_CatalogProduct
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\CatalogProduct\Block\Product\Compare;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Context;
use Magento\Catalog\Model\Product\Compare\ListCompare as ListCompareModel;
use Magento\Framework\Event\Manager as EventManager;
use Magento\Catalog\Helper\Product\Compare as CompareHelper;

class ListCompare extends \Magento\Catalog\Block\Product\Compare\ListCompare
{
    const DEFAULT_OFFSET = 0;
    
    const COMPARE_ITEMS_DISPLAY_LIMIT = 3;
    
    /* @const const DESKTOPCOUNT */
    const DESKTOPCOUNT = '3';

    /* @const const DEVICESCOUNT */
    const DEVICESCOUNT = '2';

    /* @const const MAXKEYHIGHLIGHTS */
    const MAXKEYHIGHLIGHTS = '3';
    
    public $attributeCodeStyles = [];
    public $attributeGroupStyles = [];
    
    /**
     *
     * @var ListCompareModel
     */
    public $listCompareModel;
    
    /**
     *
     * @var EventManager
     */
    public $eventManager;
    
    /**
     *
     * @var CompareHelper
     */
    public $compareHelper;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Catalog\Model\ResourceModel\Product\Compare\Item\CollectionFactory $itemCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Customer\Model\Visitor $customerVisitor
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Cybage\CatalogProduct\Model\Compare\Products $products
     * @param \Magento\Wishlist\Helper\Data $wishlistHelper
     * @param \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSet
     * @param \Magento\Catalog\Model\ResourceModel\Eav\AttributeFactory $eavattribute
     * @param ListCompareModel $listCompareModel
     * @param EventManager $eventManager
     * @param CompareHelper $compareHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Catalog\Model\ResourceModel\Product\Compare\Item\CollectionFactory $itemCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Customer\Model\Visitor $customerVisitor,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Cybage\CatalogProduct\Model\Compare\Products $products,
        \Magento\Wishlist\Helper\Data $wishlistHelper,
        \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSet,
        \Magento\Catalog\Model\ResourceModel\Eav\AttributeFactory $eavattribute,
        ListCompareModel $listCompareModel,
        EventManager $eventManager,
        CompareHelper $compareHelper,
        array $data = []
    ) {
        $this->_suggestedProducts = $products;
        $this->urlEncoder = $urlEncoder;
        $this->_itemCollectionFactory = $itemCollectionFactory;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        $this->_customerVisitor = $customerVisitor;
        $this->httpContext = $httpContext;
        $this->currentCustomer = $currentCustomer;
        $this->_wishlistHelper = $wishlistHelper;
        $this->attributeSet = $attributeSet;
        $this->_eavattribute = $eavattribute;
        $this->listCompareModel = $listCompareModel;
        $this->eventManager = $eventManager;
        $this->compareHelper = $compareHelper;
        parent::__construct(
            $context,
            $urlEncoder,
            $itemCollectionFactory,
            $catalogProductVisibility,
            $customerVisitor,
            $httpContext,
            $currentCustomer
        );
    }
    
    /**
     * Retrieve Product Compare Attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        if ($this->_attributes === null) {
            $attributes = $this->getItems()->getComparableAttributes();
            $comparableAttributes = [];
            $comparableAttributesGroup = [];

            foreach ($attributes as $attributeCode => $attribute) {
                if ($this->hasAttributeValueForProducts($attribute)) {
                    $comparableAttributes[$attributeCode] = $attribute;
                    $comparableAttributesGroup[$attributeCode] = $attribute->getAttributeGroupName() ? $attribute->getAttributeGroupName():"General";
                }
            }
            $this->_attributes = $this->arrangeComparableAttributesByGroup($comparableAttributes, $comparableAttributesGroup);
        }
        return $this->_attributes;
    }

    /**
     * Retrieve Product Attribute Value
     *
     * @param Product $product
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attribute
     * @return \Magento\Framework\Phrase|string
     */
    public function getProductAttributeValue($product, $attribute)
    {
        if (!$product->hasData($attribute->getAttributeCode())) {
            return __('-');
        }

        if ($attribute->getSourceModel() || in_array(
            $attribute->getFrontendInput(),
            ['select', 'boolean', 'multiselect']
        )
        ) {
            $value = $attribute->getFrontend()->getValue($product);
        } else {
            $value = $product->getData($attribute->getAttributeCode());
        }
        return (string) $value == '' ? __('-') : $value;
    }

    /**
     * Retrieve First Compare Product Name
     *
     * @return string
     */
    public function getCompareProductsTitle()
    {
        $itemName = '';
        foreach ($this->getItems() as $item) {
            $itemName = $item->getName() . "  v/s others";
            break;
        }
        return $itemName;
    }

    /**
     * Arrange the comparable attributes by attribute group
     *
     * @return array
     */
    public function arrangeComparableAttributesByGroup($comparableAttributes = [], $comparableAttributesGroup = [])
    {
        $comparableAttributesGroupData = [];
        $uniqueAttributeGroups = array_unique(array_values($comparableAttributesGroup));

        foreach ($uniqueAttributeGroups as $val) {
            $attributeGroupStyle = 'differentdata';

            $attributeCodes = array_keys($comparableAttributesGroup, $val);

            $arrtributesData = [];
            $attributeGrpStyles = [];
            if (!empty($attributeCodes)) {
                foreach ($attributeCodes as $attributeCode) {
                    $attributeCodeStyle = 'differentdata';

                    $attributeValues = [];
                    foreach ($this->getItems() as $item) {
                        $attributeValues[] = $this->getProductAttributeValue($item, $comparableAttributes[$attributeCode]);
                    }

                    if (count(array_unique($attributeValues)) == 1) {
                        $attributeCodeStyle = 'samedata';
                    }

                    $this->attributeCodeStyles[$attributeCode] = $attributeCodeStyle;
                    $attributeGrpStyles[] = $attributeCodeStyle;

                    $arrtributesData[$attributeCode] = $comparableAttributes[$attributeCode];
                }
                $comparableAttributesGroupData[$val] = $arrtributesData;
            }

            $uniqueAttributeGrpStyles = array_unique($attributeGrpStyles);
            if (count($uniqueAttributeGrpStyles) == 1) {
                $attributeGroupStyle = $uniqueAttributeGrpStyles[0];
            }
            $this->attributeGroupStyles[$val] = $attributeGroupStyle;
        }
        return $comparableAttributesGroupData;
    }

    /**
     * getAttributeSetId
     * @return type
     */
    public function getAttributeSetId()
    {
        $attributeSetId = '';
        foreach ($this->getItems() as $item) {
            $attributeSetId = $item->getAttributeSetId();
            break;
        }
        return $attributeSetId;
    }

    /**
     * getCompareProductsIds
     * @return type
     */
    public function getCompareProductsIds()
    {
        $producIds = [];
        foreach ($this->getItems() as $item) {
            $producIds[] = $item->getEntityId();
        }
        return $producIds;
    }

    /**
     * getSimilarCategoryProducts
     * @return type
     */
    public function getSimilarCategoryProducts()
    {
        $suggestedProducts = [];
        $attributeSetId = $this->getAttributeSetId();
        if (isset($attributeSetId) && !empty($attributeSetId)) {
            $data['attribute_set_id'] = $attributeSetId;
            $data['existing_products'] = $this->getCompareProductsIds();
            $suggestedProducts = $this->_suggestedProducts->getSimilarProducts($data);
        }
        return $suggestedProducts;
    }

    /**
     * Get Items
     * @return \Magento\Catalog\Model\ResourceModel\Product\Compare\Item\Collection
     */
    public function getItems() {
        $compareItemsCount = $this->compareHelper->getItemCount();
        if ($this->_items === null) {
            $this->_compareProduct->setAllowUsedFlat(false);

            $this->_items = $this->_itemCollectionFactory->create();
            $this->_items->useProductItem(true)->setStoreId($this->_storeManager->getStore()->getId());

            if ($this->httpContext->getValue(Context::CONTEXT_AUTH)) {
                $this->_items->setCustomerId($this->currentCustomer->getCustomerId());
            } elseif ($this->_customerId) {
                $this->_items->setCustomerId($this->_customerId);
            } else {
                $this->_items->setVisitorId($this->_customerVisitor->getId());
            }
            
            $this->_items->getSelect()->order('catalog_compare_item_id ASC');
            $this->_items->addAttributeToSelect(
                $this->_catalogConfig->getProductAttributes()
            )->loadComparableAttributes()->addMinimalPrice()->addTaxPercents()->setVisibility(
                $this->_catalogProductVisibility->getVisibleInSiteIds()
            );
            if($compareItemsCount > self::COMPARE_ITEMS_DISPLAY_LIMIT){
                $limit = $compareItemsCount - self::COMPARE_ITEMS_DISPLAY_LIMIT;
                $this->_items->getSelect()->limit($limit,self::DEFAULT_OFFSET);
                $this->removePreviousItems($this->_items);
            } else{
                $this->_items->getSelect()->order('catalog_compare_item_id ASC')->limit(self::COMPARE_ITEMS_DISPLAY_LIMIT,0);
            }
        }
        return $this->_items;
    }
    
    /**
     * Maximum number of products in compare
     */
    public function getMaxCount()
    {
        $data['desktop'] = self::DESKTOPCOUNT;
        $data['devices'] = self::DEVICESCOUNT;
        return $data;
    }
    
    /**
     * Function to get getWishlistParams
     * @param type $product
     * @return string
     */
    public function getWishlistParams($product)
    {
        $result = [];
        $result['data'] = $this->_wishlistHelper->getAddParams($product);
        $result['class'] = 'fa fa-heart-o';
        $wishlistItems = $this->_wishlistHelper->getWishlistItemCollection();
        
        foreach ($wishlistItems as $wishlistItem) {
            if ($wishlistItem->getProductId() == $product->getEntityId()) {
                $result['data'] =  $this->_wishlistHelper->getRemoveParams($wishlistItem);
                $result['class'] = 'fa fa-heart';
                break;
            }
        }
        return $result;
    }

    /**
     * getTopFeatures
     * @return type
     */
    public function getTopFeatures()
    {
        $result = [];
        $attributeSetId = $this->getAttributeSetId();
        $attributeSetRepository = $this->attributeSet->get($attributeSetId);
        $keyhighlights = $attributeSetRepository->getAttributeSetKeyhighlights();
        $keyhighlightsArray = explode(",", $keyhighlights);
        foreach ($keyhighlightsArray as $keyhighlight) {
            $attr = $this->_eavattribute->create()->load($keyhighlight);
            $result[] = [
               'attribute' => $attr,
               'icon' => $attr->getHighlightIcon()
               ];
        }
        return array_slice($result, 0, self::MAXKEYHIGHLIGHTS);
    }
    
    /**
     * Remove previously added products from Compare List and Update count
     * @param \Magento\Catalog\Model\ResourceModel\Product\Compare\Item\Collection $items
     */
    public function removePreviousItems($items) {
        if(!empty($items)){
            foreach($items as $item){
                $this->listCompareModel->removeProduct($item);
                $this->eventManager->dispatch(
                    'catalog_product_compare_remove_product',
                    ['product' => $item]
                );
            }
            $this->compareHelper->calculate();
        }
    }
}
