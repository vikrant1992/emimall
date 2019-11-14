<?php

/**
 * BFL Cybage_Storelocator
 *
 * @category   BFL Cybage_Storelocator Module
 * @package    BFL Cybage_Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Block\Index;

class Index extends \Magento\Framework\View\Element\Template
{

    const DPF = 'DPF';
    const LCF = 'LCF';
    const CDD = 'CDD';
    const CD = 'CD';
    const NTB = 'N';
    const ETB = 'E';
    const PTB = 'P';
    const LIMIT = 5;

    protected $_customerSession;
    
    /**
     * @var \Magento\MediaStorage\Helper\File\Storage\Database
     */
    protected $_fileStorageHelper;

    /**
     * Constructor
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Cybage\Storelocator\Model\CityFactory $cityFactory
     * @param \Magento\Catalog\Helper\Category $categoryHelper
     * @param \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState
     * @param \Magento\Catalog\Model\CategoryRepository $categoryRepository
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Cybage\Storelocator\Model\DealerFactory $dealerFactory
     * @param \Cybage\Storelocator\Model\DealergroupFactory $dealergroupFactory
     * @param \Cybage\Storelocator\Model\OfferFactory $offerFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageHelper
     * @param \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Cybage\Storelocator\Model\CityFactory $cityFactory,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Customer\Model\Session $customerSession,
        \Cybage\Storelocator\Model\DealerFactory $dealerFactory,
        \Cybage\Storelocator\Model\DealergroupFactory $dealergroupFactory,
        \Cybage\Storelocator\Model\OfferFactory $offerFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageHelper,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        array $data = []
    ) {
        $this->cityFactory = $cityFactory;
        $this->_categoryHelper = $categoryHelper;
        $this->categoryFlatConfig = $categoryFlatState;
        $this->_categoryRepository = $categoryRepository;
        $this->customerSession = $customerSession;
        $this->dealerFactory = $dealerFactory;
        $this->dealergroupFactory = $dealergroupFactory;
        $this->offerFactory = $offerFactory;
        $this->scopeConfig = $scopeConfig;
        $this->_fileStorageHelper = $fileStorageHelper;
        $this->cookieManager = $cookieManager;
        parent::__construct($context, $data);
    }

    /**
     * Get list of all cities
     * @return array
     */
    public function getAllCities()
    {
        $cityCollection = $this->cityFactory->create()
                ->getCollection()
                ->addFieldToSelect('*')
                ->setOrder('city_name','ASC')
                ->getData();
        return $cityCollection;
    }

    /**
     * Retrieve current store categories
     *
     * @param bool|string $sorted
     * @param bool $asCollection
     * @param bool $toLoad
     * @return \Magento\Framework\Data\Tree\Node\Collection|\Magento\Catalog\Model\Resource\Category\Collection|array
     */
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted, $asCollection, $toLoad);
    }

    /**
     * Retrieve child store categories
     *
     * @param type $category
     * @return type
     */
    public function getChildCategories($category)
    {
        if ($this->categoryFlatConfig->isFlatEnabled() && $category->getUseFlatResource()) {
            $subcategories = (array) $category->getChildrenNodes();
        } else {
            $subcategories = $category->getChildren();
        }
        return $subcategories;
    }

    /**
     * Return categories helper
     */
    public function getCategoryHelper()
    {
        return $this->_categoryHelper;
    }

    /**
     * Return the category object by its id.
     *
     * @param categoryId (Integer)
     */
    public function getCategory($categoryId)
    {
        $category = $this->_categoryRepository->get($categoryId)->getData();
        $categoryData = [];
        if (isset($category['lob']) && !empty($category['lob'])) {
            $categoryData['lob'] = $category['lob'];
        } else {
            $categoryData['lob'] = '';
        }

        if (isset($category['category_icon']) && !empty($category['category_icon'])) {
            $categoryData['icon'] = $category['category_icon'];
        } else {
            $categoryData['icon'] = '';
        }
        
        if (isset($category['custom_url']) && !empty($category['custom_url'])) {
            $categoryData['custom_url'] = $category['custom_url'];
        } else {
            $categoryData['custom_url'] = '';
        }
        return $categoryData;
    }

    /**
     * Get customer session data
     * @return array
     */
    public function getCustomerSessionData()
    {
        return $this->customerSession->getData();
    }

    /**
     * Get store list
     * @return array
     */
    public function getStoreList()
    {
        $categoryLob = $this->customerSession->getCategorylob();
        $city = $this->customerSession->getBflCustomerCityName();
        $cityId = $this->getCityId($city);
        $cityId = $cityId['bajaj_city_id'];
        $customerType = $this->customerSession->getBflCustomerFlag();
        $dealerId = $this->customerSession->getBflCustomerDealerLookup();
        if (empty($customerType)) {
             $customerType = self::NTB;
        }
        $categoryFiltersArray = $this->customerSession->getCategoryFilter();
        $groupFilter = $this->customerSession->getGroupFilter();
        $pincodeFilter = $this->customerSession->getPincodeFilter();
        
        if (isset($categoryFiltersArray)) {
            $categoryFilters = [];
            foreach ($categoryFiltersArray as $categoryFilter) {
                $categoryFilterData = $this->getCategory($categoryFilter);
                $categoryFilters[] = $categoryFilterData['lob'];
            }
            $categoryFilter = array_unique($categoryFilters);
        }
        if (isset($categoryFilter) || isset($groupFilter) || isset($pincodeFilter)) {
            $dealerCollection = $this->dealerFactory->create()
                    ->getCollection()
                    ->addFieldToFilter('city_id', ['eq' => $cityId]);
            if (!empty($groupFilter)) {
                $dealerCollection->addFieldToFilter('group_id', ['in' => $groupFilter]);
            }
            if (!empty($pincodeFilter)) {
                $dealerCollection->addFieldToFilter('pincode', ['eq' => $pincodeFilter]);
            }

            if (!empty($categoryFilter)) {
                foreach ($categoryFilter as $category) {
                    $filterArray[] = ['like' => '%' . $category . '%'];
                }
                $dealerCollection->addFieldToFilter(
                    'lob',
                    $filterArray
                );
            }
            $dealerData = $dealerCollection->getData();
            return $dealerData;
        }

        if (!empty($cityId) && !empty($categoryLob) && !empty($customerType)) {

            /* For LCF NTB user */
            if ($categoryLob == self::LCF && $customerType == self::NTB) {
                $lcfDealers = $this->getLcfDealers($cityId, $categoryLob);
                return $lcfDealers;
            }

            /* For DPF NTB user */
            if ($categoryLob == self::DPF && $customerType == self::NTB) {
                $dpfDealers = $this->getDpfDealers($cityId, $categoryLob);
                return $dpfDealers;
            }

            /* For CD NTB user */
            if (($categoryLob == self::CD || $categoryLob == self::CDD) && $customerType == self::NTB) {
                $cdDealers = $this->getCdCddDealers($cityId, self::CD);
                $cddDealers = $this->getCdCddDealers($cityId, self::CDD);
                $newCddDealerData = [];
                foreach ($cddDealers as $key => $value) {
                    $bool = array_search($value['dealer_id'], array_column($cdDealers, 'dealer_id'));
                    if ($bool === false) {
                        $newCddDealerData[] = $cddDealers[$key];
                    }
                }
                $dealerData = array_merge($cdDealers, $newCddDealerData);
                return $dealerData;
            }

            /* For DPF ETB/PTB user */
            if ($categoryLob == self::DPF && ($customerType == self::ETB || $customerType == self::PTB)) {
                $dpfDealers = $this->getDpfEtbDealers($cityId, $categoryLob, $dealerId);
                return $dpfDealers;
            }

            /* For CDD ETB/PTB user */
            if ($categoryLob == self::CDD && ($customerType == self::ETB || $customerType == self::PTB)) {
                $cddDealers = $this->getCddEtbDealers($cityId, self::CD, $dealerId);
                return $cddDealers;
            }

            /* For CD ETB/PTB user */
            if ($categoryLob == self::CD && ($customerType == self::ETB || $customerType == self::PTB)) {
                $cdCddDealers = $this->getCdEtbDealers($cityId, self::CD, $dealerId);
                return $cdCddDealers;
            }
            
            /* For LCF ETB/PTB user */
            if ($categoryLob == self::LCF && ($customerType == self::ETB || $customerType == self::PTB)) {
                return $lcfDealers = [];
            }
        } else {
            return $dpfDealers = [];
        }
    }

    /**
     * Function to return LCF dealers for NTB user
     *
     * @param type $cityId
     * @param type $categoryLob
     * @return type
     */
    public function getLcfDealers($cityId, $categoryLob)
    {
        $dealerCollection = $this->dealerFactory->create()
                ->getCollection()
                ->addFieldToFilter('city_id', ['eq' => $cityId])
                ->addFieldToFilter('lob', ['like' => '%' . $categoryLob . '%']);
        $dealerData = $dealerCollection->getData();
        if (count($dealerData) > 0) {
            return $dealerData;
        } else {
            return $dealerData = [];
        }
    }

    /**
     * Function to return DPF dealers for NTB user
     *
     * @param type $cityId
     * @param type $categoryLob
     * @return type
     */
    public function getDpfDealers($cityId, $categoryLob)
    {
        $dpfDealerCollection = $this->dealerFactory->create()
                ->getCollection()
                ->addFieldToFilter('city_id', ['eq' => $cityId])
                ->addFieldToFilter('lob', ['like' => '%' . $categoryLob . '%']);
        $dpfDealerData = $dpfDealerCollection->getData();
        $cddDealerData = $this->getCdCddDealers($cityId, self::CDD);
        $newCddDealerData = [];
        foreach ($cddDealerData as $key => $value) {
            $bool = array_search($value['dealer_id'], array_column($dpfDealerData, 'dealer_id'));
            if ($bool === false) {
                $newCddDealerData[] = $cddDealerData[$key];
            }
        }
        $dealerData = array_merge($dpfDealerData, $newCddDealerData);
        $cdDealerData = $this->getCdCddDealers($cityId, self::CD);
        $newCdDealerData = [];
        foreach ($cdDealerData as $key => $value) {
            $bool = array_search($value['dealer_id'], array_column($dealerData, 'dealer_id'));
            if ($bool === false) {
                $newCdDealerData[] = $cdDealerData[$key];
            }
        }
        $dealerData = array_merge($dealerData, $newCdDealerData);
        if (count($dealerData) > 0) {
            return $dealerData;
        } else {
            return $dealerData = [];
        }
    }

    /**
     * Function to return CD/CDD dealers
     *
     * @param type $cityId
     * @param type $cd
     * @return type
     */
    public function getCdCddDealers($cityId, $cd)
    {
        $dealerCollection = $this->dealerFactory->create()
                ->getCollection()
                ->addFieldToFilter('city_id', ['eq' => $cityId])
                ->addFieldToFilter('lob', ['like' => '%' . $cd . '%']);
        $dealerData = $dealerCollection->getData();
        return $dealerData;
    }

    /**
     * Function to return dealers LOB
     *
     * @param type $dealerId
     * @return array
     */
    public function getDealer($dealerId)
    {
        $dealerCollection = $this->dealerFactory->create()
                ->getCollection()
                ->addFieldToFilter('bajaj_dealerid', ['eq' => $dealerId])
                ->getFirstItem();
        $dealerData = $dealerCollection->getData();
        return $dealerData;
    }

    /**
     * Function to return DPF dealers for ETB user
     *
     * @param type $cityId
     * @param type $categoryLob
     * @param type $dealerId
     * @return type
     */
    public function getDpfEtbDealers($cityId, $categoryLob, $dealerId)
    {
        $preferredDealerData = $this->getDealer($dealerId);
        $preferredDealerLob = '';
        $preferredDealerLobArray = [];
        if (isset($preferredDealerData['lob'])) {
			$preferredDealerLobArray = explode(';', $preferredDealerData['lob']);
			if (in_array($categoryLob, $preferredDealerLobArray)) {
				$preferredDealerLob = $categoryLob;
			}
        }
        if ($preferredDealerLob != $categoryLob) {
            $dpfDealerCollection = $this->dealerFactory->create()
                    ->getCollection()
                    ->addFieldToFilter('city_id', ['eq' => $cityId])
                    ->addFieldToFilter('lob', ['like' => '%' . $categoryLob . '%']);
            $dpfDealerData = $dpfDealerCollection->getData();
            return $dpfDealerData;
        } else {
            if ($preferredDealerData['city_id'] == $cityId) {
                $dpfDealerCollection = $this->dealerFactory->create()
                        ->getCollection()
                        ->addFieldToFilter('city_id', ['eq' => $cityId])
                        ->addFieldToFilter('bajaj_dealerid', ['eq' => $dealerId]);
                $dpfDealerData = $dpfDealerCollection->getData();
                return $dpfDealerData;
            } else {
                $dpfDealerCollection = $this->dealerFactory->create()
                        ->getCollection()
                        ->addFieldToFilter('city_id', ['eq' => $cityId])
                        ->addFieldToFilter('group_id', ['eq' => $preferredDealerData['group_id']]);
                $dpfDealerData = $dpfDealerCollection->getData();
                if (count($dpfDealerData) > 0) {
                    return $dpfDealerData;
                } else {
                    $dpfDealers = $this->getCdCddDealers($cityId, self::DPF);
                    if (count($dpfDealers) > 0) {
                        return $dpfDealers;
                    } else {
                        $cddDealers = $this->getCdCddDealers($cityId, self::CDD);
                        if (count($cddDealers) > 0) {
                            return $cddDealers;
                        } else {
                            $cdDealers = $this->getCdCddDealers($cityId, self::CD);
                            if (count($cdDealers) > 0) {
                                return $cdDealers;
                            } else {
                                return $dpfDealerData = [];
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Function to return CDD dealers for ETB user
     *
     * @param type $cityId
     * @param type $categoryLob
     * @param type $dealerId
     * @return type
     */
    public function getCddEtbDealers($cityId, $categoryLob, $dealerId)
    {
        $preferredDealerData = $this->getDealer($dealerId);
        $preferredDealerLob = '';
        $preferredDealerLobArray = [];
        if (isset($preferredDealerData['lob'])) {
            $preferredDealerLobArray = explode(';', $preferredDealerData['lob']);
            if (in_array($categoryLob, $preferredDealerLobArray)) {
                $preferredDealerLob = $categoryLob;
            }
        }
        if ($preferredDealerLob != $categoryLob) {
            $cddDealerCollection = $this->dealerFactory->create()
                    ->getCollection()
                    ->addFieldToFilter('city_id', ['eq' => $cityId])
                    ->addFieldToFilter('lob', ['like' => '%' . $categoryLob . '%']);
            $cddDealerData = $cddDealerCollection->getData();
            return $cddDealerData;
        } else {
            if ($preferredDealerData['city_id'] == $cityId) {
                $cddDealerCollection = $this->dealerFactory->create()
                        ->getCollection()
                        ->addFieldToFilter('city_id', ['eq' => $cityId])
                        ->addFieldToFilter('bajaj_dealerid', ['eq' => $dealerId]);
                $cddDealerData = $cddDealerCollection->getData();
                return $cddDealerData;
            } else {
                $cddDealerCollection = $this->dealerFactory->create()
                        ->getCollection()
                        ->addFieldToFilter('city_id', ['eq' => $cityId])
                        ->addFieldToFilter('group_id', ['eq' => $preferredDealerData['group_id']]);
                $cddDealerData = $cddDealerCollection->getData();
                if (count($cddDealerData) > 0) {
                    return $cddDealerData;
                } else {
                    $cddDealers = $this->getCdCddDealers($cityId, self::CDD);
                    if (count($cddDealers) > 0) {
                        return $cddDealers;
                    } else {
                        $cdDealers = $this->getCdCddDealers($cityId, self::CD);
                        if (count($cdDealers) > 0) {
                            return $cdDealers;
                        } else {
                            return $cddDealerData = [];
                        }
                    }
                }
            }
        }
    }

    /**
     * Function to return CD dealers for ETB user
     *
     * @param type $cityId
     * @param type $categoryLob
     * @param type $dealerId
     * @return type
     */
    public function getCdEtbDealers($cityId, $categoryLob, $dealerId)
    {
        $preferredDealerData = $this->getDealer($dealerId);
        $preferredDealerLob = '';
        $preferredDealerLobArray = [];
        if (isset($preferredDealerData['lob'])) {
            $preferredDealerLobArray = explode(';', $preferredDealerData['lob']);
            if (in_array($categoryLob, $preferredDealerLobArray)) {
                $preferredDealerLob = $categoryLob;
            }
        }
        if ($preferredDealerLob != $categoryLob) {
            $cdDealerCollection = $this->dealerFactory->create()
                    ->getCollection()
                    ->addFieldToFilter('city_id', ['eq' => $cityId])
                    ->addFieldToFilter('lob', ['like' => '%' . $categoryLob . '%']);
            $cdDealerData = $cdDealerCollection->getData();
            return $cdDealerData;
        } else {
            if ($preferredDealerData['city_id'] == $cityId) {
                $cdDealerCollection = $this->dealerFactory->create()
                        ->getCollection()
                        ->addFieldToFilter('city_id', ['eq' => $cityId])
                        ->addFieldToFilter('bajaj_dealerid', ['eq' => $dealerId]);
                $cdDealerData = $cdDealerCollection->getData();
                return $cdDealerData;
            } else {
                $cdDealerCollection = $this->dealerFactory->create()
                        ->getCollection()
                        ->addFieldToFilter('city_id', ['eq' => $cityId])
                        ->addFieldToFilter('group_id', ['eq' => $preferredDealerData['group_id']]);
                $cdDealerData = $cdDealerCollection->getData();
                if (count($cdDealerData) > 0) {
                    return $cdDealerData;
                } else {
                    $cdDealerCollection = $this->dealerFactory->create()
                            ->getCollection()
                            ->addFieldToFilter('city_id', ['eq' => $cityId])
                            ->addFieldToFilter('lob', ['like' => '%' . $categoryLob . '%']);
                    $cdDealerData = $cdDealerCollection->getData();
                    if (count($cdDealerData) > 0) {
                        return $cdDealerData;
                    } else {
                        return $cdDealerData = [];
                    }
                }
            }
        }
    }

    /**
     * Function to return current city pincode
     */
    public function getCurrentCityPincode($limit = self::LIMIT)
    {
        $cityId = $this->getCityId($this->customerSession->getBflCustomerCityName());
        $pincodesCollection = $this->dealerFactory->create()
                ->getCollection()
                ->addFieldToFilter('city_id', ['eq' => $cityId])
                ->addFieldToSelect('pincode')
                ->distinct(true);
        if(!is_null($limit)) {
            $pincodesCollection->getSelect()->limit($limit);
        }
        $pincodes = $pincodesCollection->getData();
        if (!empty($pincodes)) {
            return $pincodes;
        }
        return $pincodes = [];
    }

    /**
     * Function to return current city
     * dealer group names
     */
    public function getCurrentCityDealerGroup($limit = self::LIMIT)
    {
        $cityId = $this->getCityId($this->customerSession->getBflCustomerCityName());
        $groupsCollection = $this->dealerFactory->create()
                ->getCollection()
                ->addFieldToFilter('city_id', ['eq' => $cityId])
                ->addFieldToSelect('group_id')
                ->distinct(true);
        if(!is_null($limit)) {
            $groupsCollection->getSelect()->limit($limit);
        }
        $groups = $groupsCollection->getData();
        if (count($groups) > 0) {
            $groupNames = [];
            foreach ($groups as $group) {
                $group = $this->dealergroupFactory->create()
                        ->getCollection()
                        ->addFieldToFilter('group_id', ['eq' => $group['group_id']])
                        ->getFirstItem()
                        ->getData();
                if (!empty($group)) {
                    $groupNames[] = $group;
                }
            }
            if (count($groupNames) > 0) {
                return $groupNames;
            } else {
                return $groupNames = [];
            }
        } else {
            return $groups = [];
        }
    }

    /**
     * Function to return dealer offers
     */
    public function getDealerOffer($dealerId)
    {
        $offer = $this->offerFactory->create()
                ->getCollection()
                ->addFieldToFilter('dealerid', ['eq' => $dealerId])
                ->getFirstItem()
                ->getData();
        if (isset($offer['offer_text'])) {
            return $offer['offer_text'];
        } else {
            return '';
        }
    }

    /**
     * Function to return path for default logo
     * @return string
     */
    public function getDefaultImage()
    {
        return $this->scopeConfig->getValue("storelocator/dealer/default_logo");
    }
    
    /**
     * Function to return city id by name
     * @return string
     */
    public function getCityId($city)
    {
        $cityData = $this->cityFactory->create()
                ->getCollection()
                ->addFieldToFilter('city_name', ['eq' => strtoupper($city)])
                ->addFieldToSelect('bajaj_city_id')
                ->getFirstItem()
                ->getData();
        return $cityData;
    }
    
    /**
     * Return the category URL.
     *
     * @param categoryId (Integer)
     */
    public function getCategoryUrl($categoryId)
    {
        $categoryUrl = $this->_categoryRepository->get($categoryId)->getUrl();
        return $categoryUrl;
    }
    
    /**
     * Check if current url is url for home page
     *
     * @deprecated 101.0.1 This function is no longer used. It was previously used by
     * Magento/Theme/view/frontend/templates/html/header/logo.phtml
     * to check if the logo should be clickable on the homepage.
     *
     * @return bool
     */
    public function isHomePage()
    {
        $currentUrl = $this->getUrl('', ['_current' => true]);
        $urlRewrite = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        return $currentUrl == $urlRewrite;
    }

    /**
     * Get logo image URL
     *
     * @return string
     */
    public function getLogoSrc()
    {
        if (empty($this->_data['logo_src'])) {
            $this->_data['logo_src'] = $this->_getLogoUrl();
        }
        return $this->_data['logo_src'];
    }

    /**
     * Retrieve logo text
     *
     * @return string
     */
    public function getLogoAlt()
    {
        if (empty($this->_data['logo_alt'])) {
            $this->_data['logo_alt'] = $this->_scopeConfig->getValue(
                'design/header/logo_alt',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
        return $this->_data['logo_alt'];
    }

    /**
     * Retrieve logo width
     *
     * @return int
     */
    public function getLogoWidth()
    {
        if (empty($this->_data['logo_width'])) {
            $this->_data['logo_width'] = $this->_scopeConfig->getValue(
                'design/header/logo_width',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
        return (int)$this->_data['logo_width'] ? : (int)$this->getLogoImgWidth();
    }

    /**
     * Retrieve logo height
     *
     * @return int
     */
    public function getLogoHeight()
    {
        if (empty($this->_data['logo_height'])) {
            $this->_data['logo_height'] = $this->_scopeConfig->getValue(
                'design/header/logo_height',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
        return (int)$this->_data['logo_height'] ? : (int)$this->getLogoImgHeight();
    }

    /**
     * Retrieve logo image URL
     *
     * @return string
     */
    protected function _getLogoUrl()
    {
        $folderName = \Magento\Config\Model\Config\Backend\Image\Logo::UPLOAD_DIR;
        $storeLogoPath = $this->_scopeConfig->getValue(
            'design/header/logo_src',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $path = $folderName . '/' . $storeLogoPath;
        $logoUrl = $this->_urlBuilder
                ->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]) . $path;

        if ($storeLogoPath !== null && $this->_isFile($path)) {
            $url = $logoUrl;
        } elseif ($this->getLogoFile()) {
            $url = $this->getViewFileUrl($this->getLogoFile());
        } else {
            $url = $this->getViewFileUrl('images/logo.svg');
        }
        return $url;
    }

    /**
     * If DB file storage is on - find there, otherwise - just file_exists
     *
     * @param string $filename relative path
     * @return bool
     */
    protected function _isFile($filename)
    {
        if ($this->_fileStorageHelper->checkDbUsage() && !$this->getMediaDirectory()->isFile($filename)) {
            $this->_fileStorageHelper->saveFileToFilesystem($filename);
        }

        return $this->getMediaDirectory()->isFile($filename);
    }
	
	/**
     * Function to return 
     * @return string
     */
    public function getIpinfo()
    {
        return $this->scopeConfig->getValue("storelocator/storelocator/ipinfo_api");
    }
    
    /**
     * Function to return API key
     * @return string
     */
    public function getApikey()
    {
        return $this->scopeConfig->getValue("storelocator/storelocator/api_key");
    }
    
    /**
     * Function to return API URL
     * @return string
     */
    public function getApiurl()
    {
        return $this->scopeConfig->getValue("storelocator/storelocator/geolocation_api_url");
    }
    
    /** Get City Cookie value */
    public function getCityCookie()
    {
        return $this->cookieManager->getCookie(
            'city'
        );
    }
	
	/**
     * Function to return content copy config value
     * @return string
     */
    public function isContentCopyEnabled()
    {
        return $this->scopeConfig->getValue("content_copy_config/sfdc/enable");
    }
    
    /**
     * Function to return content copy config value
     * @return string
     */
    public function getNumberofStoresPerpage()
    {
        return $this->scopeConfig->getValue("storelocator/mapconfiguration/stores_per_page");
    }

    /**
     * Function to return view file url
     * @return string
     */
    public function getFileUrl($file)
    {
        return $this->getViewFileUrl($file);
    }
}
