<?php
/**
 * BFL Cybage_CustomWishlist
 *
 * @category   Cybage_CustomWishlist Module
 * @package    BFL Cybage_CustomWishlist
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\CustomWishlist\Helper;

use Magento\Framework\App\ActionInterface;
use Magento\Wishlist\Controller\WishlistProviderInterface;
use Magento\Framework\App\Request\Http;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    const OFFSET = 10;
    
    /**
     * Currently logged in customer
     *
     * @var \Magento\Customer\Api\Data\CustomerInterface
     */
    protected $_currentCustomer;

    /**
     * Customer Wishlist instance
     *
     * @var \Magento\Wishlist\Model\Wishlist
     */
    protected $_wishlist;

    /**
     * Wishlist Product Items Collection
     *
     * @var \Magento\Wishlist\Model\ResourceModel\Item\Collection
     */
    protected $_productCollection;

    /**
     * Wishlist Items Collection
     *
     * @var \Magento\Wishlist\Model\ResourceModel\Item\Collection
     */
    protected $_wishlistItemCollection;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Wishlist\Model\WishlistFactory
     */
    protected $_wishlistFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Data\Helper\PostHelper
     */
    protected $_postDataHelper;

    /**
     * @var \Magento\Customer\Helper\View
     */
    protected $_customerViewHelper;

    /**
     * @var \Magento\Wishlist\Controller\WishlistProviderInterface
     */
    protected $wishlistProvider;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Wishlist\Model\WishlistFactory $wishlistFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Helper\PostHelper $postDataHelper
     * @param \Magento\Customer\Helper\View $customerViewHelper
     * @param WishlistProviderInterface $wishlistProvider
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param Http $http
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Wishlist\Model\WishlistFactory $wishlistFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Customer\Helper\View $customerViewHelper,
        WishlistProviderInterface $wishlistProvider,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Helper\Image $imageHelper,
        Http $http
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_customerSession = $customerSession;
        $this->_wishlistFactory = $wishlistFactory;
        $this->_storeManager = $storeManager;
        $this->_postDataHelper = $postDataHelper;
        $this->_customerViewHelper = $customerViewHelper;
        $this->wishlistProvider = $wishlistProvider;
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        $this->http = $http; 
        parent::__construct($context);
    }

    /**
     * Retrieve wishlist by logged in customer
     *
     * @return \Magento\Wishlist\Model\Wishlist
     */
    public function getWishlistId()
    {
        if ($this->_wishlist === null) {
            if ($this->_coreRegistry->registry('shared_wishlist')) {
                $this->_wishlist = $this->_coreRegistry->registry('shared_wishlist');
            } else {
                $this->_wishlist = $this->wishlistProvider->getWishlist();
            }
        }
        return $this->_wishlist->getId();
    }
    
    /**
     * Get Clear All Params
     * @return string
     */
    public function getClearAllParams()
    {
        $url = $this->_getUrl('customwishlist/index/remove');
        $params = ['wishlist_id' => $this->getWishlistId(),'is_clear_all'=> 1];
        $params[ActionInterface::PARAM_NAME_URL_ENCODED] = '';
        return $this->_postDataHelper->getPostData($url, $params);
    }
    
    /**
     * Get Remove Wishlist Params
     * @param int $itemId
     * @param int $isClearAll
     * @return string
     */
    public function getRemoveWishlistParams($itemId,$isClearAll = 0)
    {
        $url = $this->_getUrl('customwishlist/index/remove');
        $params = ['item_id' => $itemId,'is_clear_all'=> $isClearAll];
        $params[ActionInterface::PARAM_NAME_URL_ENCODED] = '';
        return $this->_postDataHelper->getPostData($url, $params);
    }
    
    /**
     * Get Wishlist Items for Ajax Load
     * @return object
     */
    public function getWishlistItems(){
        $currentUserWishlist = $this->wishlistProvider->getWishlist();
        if ($currentUserWishlist) {
            $wishColl =  $currentUserWishlist->getItemCollection();
            $pageSize = $wishColl->getSize();
            $wishColl->getSelect()->limit($pageSize,self::OFFSET);
            return $wishColl;
        }
    }
    
    /**
     * Get Product Image Url
     * @param int $productId
     * @return array
     */
    public function getProductImageUrl($productId){
        $product = $this->productRepository->getById($productId);
        $imageUrl = $this->imageHelper->init($product, 'product_base_image')
            ->constrainOnly(true)
            ->keepAspectRatio(true)
            ->keepTransparency(true)
            ->keepFrame(false)
            ->getUrl();
        return $imageUrl;
    }
    
    /**
     * Get HTTP instance
     * @return \Magento\Framework\App\Request\Http
     */
    public function getHttpInstance() {
        return $this->http;
    }
    
    /**
     * 
     * @return bool
     */
    public function isCustomerLoggedIn() {
        return $this->_customerSession->isLoggedIn();
    }
    
    /**
     * Set Referrer Url
     * @param string $refUrl
     */
    public function setReferrerUrl($refUrl) {
        if(strpos($refUrl, '/wishlist') === false){
            $this->_customerSession->setWishlistReferrerUrl($refUrl);
        }
    }
    
    /**
     * Get Customer Session
     * @return string
     */
    public function getCustomerSession() {
        return $this->_customerSession;
    }
}
