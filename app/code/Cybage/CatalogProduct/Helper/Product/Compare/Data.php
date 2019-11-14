<?php
/**
 * BFL CatalogProduct
 *
 * @category   CatalogProduct Module
 * @package    BFL CatalogProduct
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\CatalogProduct\Helper\Product\Compare;

use Magento\Framework\App\Response\RedirectInterface;

class Data extends \Magento\Catalog\Helper\Product\Compare
{
    const YES = 'Yes';
    
    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $_jsonEncoder;
    
    /**
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
    
    /**
     * @var RedirectInterface
     */
    protected $redirect;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\ResourceModel\Product\Compare\Item\CollectionFactory $itemCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Customer\Model\Visitor $customerVisitor
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Model\Session $catalogSession
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     * @param \Magento\Wishlist\Helper\Data $wishlistHelper
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     * @param RedirectInterface $redirect
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ResourceModel\Product\Compare\Item\CollectionFactory $itemCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Customer\Model\Visitor $customerVisitor,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Model\Session $catalogSession,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Wishlist\Helper\Data $wishlistHelper,
        \Magento\Framework\Data\Helper\PostHelper $postHelper,
        RedirectInterface $redirect
    ) {
        parent::__construct(
            $context,
            $storeManager,
            $itemCollectionFactory,
            $catalogProductVisibility,
            $customerVisitor,
            $customerSession,
            $catalogSession,
            $formKey,
            $wishlistHelper,
            $postHelper
        );
        $this->customerSession = $customerSession;
        $this->redirect = $redirect;
    }

    /**
     * getAjaxAddUrl
     * @return type
     */
    public function getAjaxAddUrl()
    {
        return $this->_getUrl('customcatalog/product/ajaxadd');
    }
    
    public function getAjaxPostDataParams($product)
    {
        $params = ['product' => $product->getId()];
        $requestingPageUrl = $this->_getRequest()->getParam('requesting_page_url');

        if (!empty($requestingPageUrl)) {
            $encodedUrl = $this->urlEncoder->encode($requestingPageUrl);
            $params[\Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED] = $encodedUrl;
        }

        return $this->postHelper->getPostData($this->getAjaxAddUrl(), $params);
    }

    /**
     * isInCollection
     * @param type $product
     * @return boolean
     */
    public function isInCollection($product)
    {
        $collection = $this->getItemCollection();
        if ($collection) {
            foreach ($collection as $compareProduct) {
                if ($compareProduct->getId() == $product->getId()) {
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * getCompareDetailUrl
     * @return type
     */
    public function getCompareDetailUrl()
    {
        return $this->_getUrl('catalog/product_compare');
    }
    
    /**
     * Set Referrer Url
     * @param string $refUrl
     */
    public function setComparePageReferrerUrl($refUrl) {
        if((strpos($refUrl, '/catalog/product_compare') === false) && (strpos($refUrl, '/customer/section/load/') === false)){
            $this->customerSession->setCompareReferrerUrl($refUrl);
        }
    }
    
    /**
     * Get Customer Session
     * @return string
     */
    public function getCustomerSession() {
        return $this->customerSession;
    }
    
    /**
     * Get Redirect Instance
     * @return object
     */
    public function getRedirectInstance() {
        return $this->redirect;
    }
}
