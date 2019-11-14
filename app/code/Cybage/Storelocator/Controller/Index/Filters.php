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

namespace Cybage\Storelocator\Controller\Index;

use Cybage\Storelocator\Block\Index\Index;

class Filters extends \Magento\Framework\App\Action\Action {

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;
    protected $storesBlock;

    /**
     * Constructor
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param Index $storeBlock
     */
    public function __construct(
    \Magento\Framework\App\Action\Context $context, Index $storeBlock, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->storesBlock = $storeBlock;
        $this->resultRawFactory = $resultRawFactory;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Execute view action
     * return string
     */
    public function execute() {
        $data = $this->getRequest()->getPostValue();
        $result = $this->resultRawFactory->create();
        $customerData = $this->storesBlock->getCustomerSessionData();
        if(!isset($customerData['group_filter'])) {
            $customerData['group_filter'] = [];
        }
        if(!isset($customerData['pincode_filter'])) {
            $customerData['pincode_filter'] = [];
        }
        //Pincode filters
        if (isset($data['pincode'])) {
            $allPincodes = $this->storesBlock->getCurrentCityPincode(NULL);
            $html = '';
            foreach ($allPincodes as $pincode) {
                $html .= '<li>
                        <p>
                            <input type="radio" id="' . $pincode['pincode'] . '" name="pincode" value="' . $pincode['pincode'] . '"';
                if($pincode['pincode'] == $customerData['pincode_filter']) {
                    $html .= 'checked="checked"';
                }
                            $html .= '/><label for="' . $pincode['pincode'] . '">' . $pincode['pincode'] . ' </label>
                        </p>
                    </li>';
            }
            $result->setContents($html);
            return $result;
        }

        //Group filter
        if (isset($data['groups'])) {
            $allGroups = $this->storesBlock->getCurrentCityDealerGroup(NULL);
            $html = '';
            foreach ($allGroups as $group) {
                $html .= '<li>
                        <p>
                            <input type = "checkbox" id = "' . $group['group_id'] . '" value = "' . $group['group_id'] . '"  name="group[]"';
                if(in_array($group['group_id'], $customerData['group_filter'])) {
                    $html .= 'checked="checked"';
                }
                $html .= '><label for = "' . $group['group_id'] . '">' . $group['store_name'] . '</label>
                        </p>
                    </li>';
            }
            $result->setContents($html);
            return $result;
        }

        //Store details
        if (isset($data['storedetails'])) {
            $store = $this->storesBlock->getDealer($data['storedetails']);
            $html = '';
            $html .= '<div class="p_storeloction" style="display: block;">'
                    . '<div class="storehead">
                        <p>
                            <img src="' . $this->storesBlock->getFileUrl("images/closesim.png") . '" alt="">' . __("Store details") . '
                        </p>
                       </div>';

            /* Store title and logo start */
            $html .= '<div class="p_loctiontitle">';
            if (empty($store['dealer_logo'])) {
                $html .= '<img src = "' . $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . '/dealer/' . $this->storesBlock->getDefaultImage() . '" alt = "">';
            } else {
                $html .= '<img src = "' . $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . '/cybage/dealer' . $store['dealer_logo'] . '" alt = "">';
            }
            $html .= '<h2>'
                    . '<img src="' . $this->storesBlock->getFileUrl('images/back_black.svg') . '" alt="">'
                    . $store['dealer_name'] . ', '
                    . $store['area']
                    . '</h2>
                </div>';
            /* Store title and logo end */

            /* Address Start */
            $html .= '<div class="p_loctiondetils">
                        <p>' . $store['address'] . '</p>
                    </div>';
            /* Address Ends */

            /* Buttons Start */
            $html .= '<div class = "p_storecallderction">
                        <div class = "p_storegetdriction">
                            <a href = "javascript:void(0);" class = "getdirection" data-lat = "' . $store['latitude'] . '" data-long = "' . $store['longitude'] . '">
                            <img src = "' . $this->storesBlock->getFileUrl('images/ico-directio.png') . '" alt = "">
                            <p>' . __('Get Directions') . '</p>
                            </a>
            		</div>
            		<div class="p_storecall">
                            <a href="javascript:void(0);"><img src="' . $this->storesBlock->getFileUrl('images/ico-call-wht.svg') . '" alt="phone-forwarded">'
                    . '<p>' . __('Contact Store') . '</p>
                        </a>
                    </div>
                </div>';
            /* Buttons End */

            /* Offer Section Starts */
            if (!empty($offer = $this->storesBlock->getDealerOffer($store['bajaj_dealerid']))) {
                $html .= '<div class="p_instoreoffer">
                    <div class="a_instoreOffr">
                        <div class="a_offersHead">
                            <h4>' . __('In-Store Offers') . '</h4>
                            <p>' . __('Find exclusive offers on products in nearby stores') . '</p>
                        </div>
                        <div class="a_FlatSlide">
                            <div class="demo">
                                <div class="demo__content">
                                    <div class="secondCard"></div>
                                    <div class="lastCard"></div>
                                    <div class="demo__card-cont">
                                        <div class="demo__card">
                                            <div class="demo__card__top">
                                                <div class="a_FcashBackPad">
                                                    <div class="a_FcashBack">
                                                        <div class="flateHed purple">
                                                            <p></p>
                                                        </div>
                                                        <div class="a_cardConflat">
                                                            <h4>' . $offer . '</h4>
                                                            <i>' . __('*T&C Apply') . '</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="demo__card__choice m--reject"><i class="fas fa-thumbs-down"></i><p>' . __('Dislike') . '</p></div>
                                            <div class="demo__card__choice m--like"><i class="fas fa-thumbs-up"></i><p>' . __('Like') . '</p></div>
                                            <div class="demo__card__drag"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            /* Offer Section Ends */
            $html .= '</div>';

            /* Callback section start */
            $html .= '<div class="a_likespops">
                        <div class="a_likebLack">
                            <div class="a_innerLinke">
                                <p>' . __('Want to get a call back from') . $store['dealer_name'] . '?</p>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="likeno">' . __('No') . '</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="likeyes">' . __('Yes') . '</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>';
            /* Callback section end */
            $result->setContents($html);
            return $result;
        }
    }

}
