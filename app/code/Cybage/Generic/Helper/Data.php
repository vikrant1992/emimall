<?php
/**
 * BFL Cybage_Generic
 *
 * @category   Cybage_Generic Helpere
 * @package    BFL Cybage_Generic
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Generic\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Locale\CurrencyInterface;

class Data extends AbstractHelper {

    const XML_PATH_MEDIAURL = 'general_config/general/catalog_media_url';

    /**
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $modelStoreManagerInterface
     * @param CurrencyInterface $localeCurrency
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $modelStoreManagerInterface,
        CurrencyInterface $localeCurrency
    ) {
        $this->_modelStoreManagerInterface = $modelStoreManagerInterface;
        $this->_localeCurrency = $localeCurrency;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Get Any Store Configuration
     *
     * @param string $storePath Full path of any configuration
     * @return string $storeConfig
     */
    public function getStoreConfig($storePath)
    {
        $storeConfig = $this->_scopeConfig->getValue($storePath, ScopeInterface::SCOPE_STORE);
        return $storeConfig;
    }

    /**
     * getCustomMediaUrl
     * @param type $storeId
     * @return type
     */
    public function getCustomMediaUrl($storeId = null)
    {
        return $this->getStoreConfig(self::XML_PATH_MEDIAURL);
    }

    /**
     * getCurrentCurrencySymbol
     * @return type
     */
    public function getCurrentCurrencySymbol()
    {
        $currencyCode = $this->_modelStoreManagerInterface->getStore()->getBaseCurrencyCode();
        $currencySymbol = $this->_localeCurrency->getCurrency($currencyCode)->getSymbol();
        return $currencySymbol;
    }

    /**
     * getWishlistAddUrl
     * @return type String
     */
    public function getWishlistAddUrl()
    {
        $url = $this->_getUrl('wishlist/index/add');
        return $url;
    }

    /**
     * getWishlistRemoveUrl
     * @return type String
     */
    public function getWishlistRemoveUrl()
    {
        $url = $this->_getUrl('wishlist/index/remove');
        return $url;
    }
}
