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
namespace Cybage\CustomWishlist\Block\Customer\Wishlist\Item\Column;

use Magento\Framework\App\ActionInterface;
use Magento\Customer\Model\Session as CustomerSession;
/**
 * CustomInfo
 */
class CustomInfo extends \Magento\Wishlist\Block\Customer\Wishlist\Item\Column
{
    
    /**
     *
     * @var CustomerSession
     */
    protected $customerSession;
    
    /**
     * @var \Magento\Framework\Data\Helper\PostHelper
     */
    protected $_postDataHelper;
    
    /**
     *
     * @var \Magento\Wishlist\Model\Wishlist 
     */
    protected $wishlist;
    
    /**
     * Constructor
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param CustomerSession $customerSession
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Magento\Framework\Data\Helper\PostHelper $postDataHelper
     * @param \Magento\Wishlist\Model\Wishlist $wishlist
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        CustomerSession $customerSession,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Wishlist\Model\Wishlist $wishlist
    ){
        parent::__construct($context, $httpContext);
        $this->customerSession = $customerSession;
        $this->_postDataHelper = $postDataHelper;
        $this->wishlist = $wishlist;
    }
    
    /**
     * Get Item Sold Count
     * @param int $prodId
     * @return string
     */
    public function getItemSoldCount($prodId) {
        /* This function at present returns hardcode count of sold quantity, the dynamic logic yet to implement */
        $soldCount = 4500;
        if(!$this->customerSession->isLoggedIn()){
            $this->resultRedirectFactory->create()->setPath('customer/account/login');
        }
        return $soldCount;
    }
    
    /**
     * Get Clear Wishlist Url and Params
     * @return string
     */
    public function getClearWishlistParams()
    {
        if(!$this->customerSession->isLoggedIn()){
            $this->resultRedirectFactory->create()->setPath('customer/account/login');
        }
        $customerId = $this->customerSession->getCustomer()->getId();
        $wishlistId = $this->getWishlistByCustomerId($customerId);
        $url = $this->getUrl('customwishlist/index/remove');
        $params = ['wishlist_id' => $wishlistId];
        $params[ActionInterface::PARAM_NAME_URL_ENCODED] = '';
        return $this->_postDataHelper->getPostData($url,$params);
    }
    
    /**
     * Get Wishlist By CustomerId
     * @param int $customerId
     * @return int
     */
    public function getWishlistByCustomerId($customerId){
        return $this->wishlist->loadByCustomerId($customerId)->getId();
    }
    
    /**
     * Get Wishlist items count
     * @return int
     */
    public function getWishlistitemsCount(){
        if(!$this->customerSession->isLoggedIn()){
            $this->resultRedirectFactory->create()->setPath('customer/account/login');
        }
        $customerId = $this->customerSession->getCustomer()->getId();
        return $this->wishlist->loadByCustomerId($customerId)->getItemsCount();
    }
}
