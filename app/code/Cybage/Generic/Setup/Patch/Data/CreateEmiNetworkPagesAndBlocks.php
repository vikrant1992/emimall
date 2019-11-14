<?php

/**
 * BFL Cybage_Generic
 *
 * @category   Cybage_Generic Module
 * @package    BFL Cybage_Generic
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Generic\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\BlockFactory;

/**
 */
class CreateEmiNetworkPagesAndBlocks implements DataPatchInterface, PatchRevertableInterface {

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     *
     * @var PageFactory
     */
    private $pageFactory;

    /**
     *
     * @var BlockFactory 
     */
    private $blockFactory;

    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param PageFactory $pageFactory
     * @param BlockFactory $blockFactory
     */
    public function __construct(
    \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup, EavSetupFactory $eavSetupFactory, PageFactory $pageFactory, BlockFactory $blockFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->pageFactory = $pageFactory;
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply() {
        $this->createEmiCard();
        $this->createEmiCardFeatures();
        $this->createEmiFeatureCategories();
        $this->createEmiCardSteps();
        $this->createEmiFaqs();
        $this->createEmiNetworkPage();
    }

    /**
     * Create Static Blocks
     */
    public function createEmiCard() {
        //Main Banner Block
        $GetEMINetworkCardBlock = [
            'title' => 'Get EMI Network Card',
            'identifier' => 'emi-network-get-card',
            'content' => '<section class="j_shopcardProd">
                <div class="j_padd">
                <div class="j_cardDescLeft">
                <h1>Shop for products on easy EMIs</h1>
                <p>You can now shop for everything you want and more with the Bajaj Finserv EMI Network Card</p>
                <div class="j_getEmiNCard"><a href="javascript:void(0);">Get your EMI Network Card</a></div>
                </div>
                <div class="j_cardimgright"><img src="{{view url=images/emi-network/emi_network_card.png}}" alt=""></div>
                </div>
                </section>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $this->blockFactory->create()->setData($GetEMINetworkCardBlock)->save();
    }

    public function createEmiCardFeatures() {
        //Main Banner Block
        $GetEMINetworkCardBlock = [
            'title' => 'EMI Network Card Features',
            'identifier' => 'emi-network-card-features',
            'content' => '<section class="j_emiNetFea">
                <div class="j_padd">
                <div class="j_featureSec">
                <div class="j_fullWFeat">
                <h2>EMI Network Card Features</h2>
                <div class="j_fea_step">
                <div class="j_perStep">
                <div class="j_stepImg"><img src="{{view url=images/emi-network/mi.png}}" alt="mi"></div>
                <div class="j-stepsDes">
                <h4>No Cost EMI</h4>
                <p>Choose a product and get it on no cost EMI from any partnered store</p>
                </div>
                </div>
                <div class="j_perStep">
                <div class="j_stepImg"><img src="{{view url=images/emi-network/mi.png}}" alt="mi"></div>
                <div class="j-stepsDes">
                <h4>Repay Easily</h4>
                <p>Divide your purchase into easy EMIs of 3, 6, 9, 12, 18 or 24 months</p>
                </div>
                </div>
                <div class="j_perStep">
                <div class="j_stepImg"><img src="{{view url=images/emi-network/mi.png}}" alt="mi"></div>
                <div class="j-stepsDes">
                <h4>Same Day Delivery</h4>
                <p>The product will be delivered to you within 4 hours / same day delivery</p>
                </div>
                </div>
                <div class="j_perStep">
                <div class="j_stepImg"><img src="{{view url=images/emi-network/mi.png}}" alt="mi"></div>
                <div class="j-stepsDes">
                <h4>Get pre-approved loans &amp; offers</h4>
                <p>The Bajaj Finserv EMI Network Card comes with a pre-approved loan of up to Rs.4 lakh</p>
                </div>
                </div>
                <div class="j_perStep">
                <div class="j_stepImg"><img src="{{view url=images/emi-network/mi.png}}" alt="mi"></div>
                <div class="j-stepsDes">
                <h4>Minimal Down Payment</h4>
                <p>Products brought on EMI Network have minimal or no down payment</p>
                </div>
                </div>
                <div class="j_perStep">
                <div class="j_stepImg"><img src="{{view url=images/emi-network/mi.png}}" alt="mi"></div>
                <div class="j-stepsDes">
                <h4>Minimum Documentation</h4>
                <p>All you need are KYC documents and a cancelled cheque.</p>
                </div>
                </div>
                <div class="j_termCon"><a href="/terms-and-conditions">Read Terms &amp; Conditions</a></div>
                </div>
                </div>
                </div>
                </div>
                </section>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $this->blockFactory->create()->setData($GetEMINetworkCardBlock)->save();
    }

    public function createEmiFeatureCategories() {
        //Main Banner Block
        $GetEMINetworkCardBlock = [
            'title' => 'EMI Network Feature Categories',
            'identifier' => 'emi-network-feature-categories',
            'content' => '<section class="p_futuchercat">
            <div class="p_leftandright">
            <div class="p_titlefutucher">
            <h2>Featured Categories</h2>
            <a href="javascript:void(0);">View All</a></div>
            <div class="p_catlistfutucher">
            <ul>
            <li><a href="mobiles-and-electronics/mobiles">
            <div class="p_catlistbg"><img class="lazy" src="{{media url=&quot;frame-landscape.png&quot;}}" data-src="{{view url=images/emi-network/MobilePhone.png}}" alt="MobilePhone"></div>
            <p>Smartphones</p>
            </a></li>
            <li><a href="tvs-and-large-appliances/televisions">
            <div class="p_catlistbg"><img class="lazy" src="{{media url=&quot;frame-landscape.png&quot;}}" data-src="{{view url=images/emi-network/TV.png}}" alt="TV"></div>
            <p>Laptops</p>
            </a></li>
            <li><a href="mobiles-and-electronics/laptops">
            <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/emi-network/Laptop.png}}" alt="Laptop"></div>
            <p>Refrigerators</p>
            </a></li>
            <li><a href="tvs-and-large-appliances/refrigerators">
            <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/emi-network/Refrigerator.png}}" alt="Refrigerator"></div>
            <p>Speakers</p>
            </a></li>
            <li><a href="tvs-and-large-appliances/washing-machines">
            <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/emi-network/Washing-Machine.png}}" alt="WashingMachine"></div>
            <p>Washing Machines</p>
            </a></li>
            <li><a href="kitchen-appliances/microwave-oven">
            <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/emi-network/Microwave.png}}" alt="Microwave"></div>
            <p>Televisions</p>
            </a></li>
            <li><a href="tvs-and-large-appliances/air-conditioners">
            <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/emi-network/AC.png}}" alt="AC"></div>
            <p>Speakers</p>
            </a></li>
            <li><a href="kitchen-appliances/water-purifier">
            <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/emi-network/Water-Purifier.png}}" alt="Water-Purifier"></div>
            <p>Laptops</p>
            </a></li>
            <li><a href="mobiles-and-electronics/desktop">
            <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/emi-network/Desktop.png}}" alt="Desktop"></div>
            <p>Printers</p>
            </a></li>
            <li><a href="small-home-appliances/water-heater">
            <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/emi-network/Water-Heater.png}}" alt="Water-Heater"></div>
            <p>Smartphones</p>
            </a></li>
            <li><a href="kitchen-appliances/juicer">
            <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/emi-network/Juicer.png}}" alt="Juicer"></div>
            <p>Smart Watches</p>
            </a></li>
            <li><a href="mobiles-and-electronics/home-theatre-speaker">
            <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/emi-network/Home-Theater.png}}" alt="HomeTheater"></div>
            <p>Gaming PC</p>
            </a></li>
            </ul>
            </div>
            </div>
            </section>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $this->blockFactory->create()->setData($GetEMINetworkCardBlock)->save();
    }
    
    public function createEmiCardSteps() {
        //Main Banner Block
        
        $GetEMINetworkCardBlock = [
            'title' => 'EMI Network Card Steps',
            'identifier' => 'emi-network-card-steps',
            'content' => '<section class="j_emiCardStep">
            <div class="j_padd">
            <div class="j_secfull">
            <div class="step_j_left">
            <h2>Get your EMI Network Card in 4 steps</h2>
            <div class="jstepsList">
            <div class="j_SList">
            <div class="j_stpTx">
            <p>Step 1</p>
            </div>
            <div class="j_stpDesTx">
            <p>Take your PAN Card, Aadhaar Card and a Cancelled Cheque from a registered Bank Account</p>
            </div>
            </div>
            <div class="j_SList">
            <div class="j_stpTx">
            <p>Step 2</p>
            </div>
            <div class="j_stpDesTx">
            <p>Visit our partnered store near you to find a product to purchase</p>
            </div>
            </div>
            <div class="j_SList">
            <div class="j_stpTx">
            <p>Step 3</p>
            </div>
            <div class="j_stpDesTx">
            <p>Meet with our Bajaj Finserve EMI Representative and hand over your documents</p>
            </div>
            </div>
            <div class="j_SList">
            <div class="j_stpTx">
            <p>Step 4</p>
            </div>
            <div class="j_stpDesTx">
            <p>Get your pre-approved amount and EMI Network Card in your Bajaj Finserv Wallet app</p>
            </div>
            </div>
            </div>
            </div>
            <div class="j_findStore">
            <div class="j_storeFull">
            <h3>Shop from any of our 60,000+ partner stores</h3>
            <p>Using your pre-approved offer of 80,000</p>
            <a href="JavaScript:void(0);" id="emiFindStore">Find Stores</a>
            <div class="j_shopingCarimg"><img src="{{view url=images/emi-network/find-store.png}}" alt=""></div>
            </div>
            </div>
            </div>
            </div>
            </section>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $this->blockFactory->create()->setData($GetEMINetworkCardBlock)->save();
    }
    
    public function createEmiFaqs() {
        //Main Banner Block
        
        $GetEMINetworkCardBlock = [
            'title' => 'EMI Network FAQs',
            'identifier' => 'emi-network-faqs',
            'content' => '<section class="j_faqSec">
            <div class="j_padd">
            <div class="j_faqDiv">
                <div class="j_fullWfaq">
                    <h4>FAQs</h4>
                    <div class="j_faqSlide">
                        <div class="j_sepSlide">
                            <a href="javascript:void(0);" class="active">
                                <p>What is the battery life offered?</p>
                                <i class="fa fa-minus"></i>
                            </a>
                            <p class="j_displBlock p_disdatablock">The battery back-up of the Apple iPad 32GB is one of the best in the market. With moderate to high usage, the device runs for more than 10 hours. Very good for multimedia usage.</p>
                        </div>
                        <div class="j_sepSlide">
                            <a href="javascript:void(0);">
                                <p>Can I use my phone’s hotspot to connect the Apple iPad 32GB wi-fi tablet?</p>
                                <i class="fa fa-plus"></i>
                            </a>
                            <p class="j_displBlock">The battery back-up of the Apple iPad 32GB is one of the best in the market. With moderate to high usage, the device runs for more than 10 hours. Very good for multimedia usage.</p>
                        </div>
                        <div class="j_sepSlide">
                            <a href="javascript:void(0);">
                                <p>What is the resolution of the screen?</p>
                                <i class="fa fa-plus"></i>
                            </a>
                            <p class="j_displBlock">The battery back-up of the Apple iPad 32GB is one of the best in the market. With moderate to high usage, the device runs for more than 10 hours. Very good for multimedia usage.</p>
                        </div>
                        <div class="j_sepSlide">
                            <a href="javascript:void(0);">
                                <p>How many EMIs can I opt for through Bajaj Finserv EMI network card?</p>
                                <i class="fa fa-plus"></i>
                            </a>
                            <p class="j_displBlock">The battery back-up of the Apple iPad 32GB is one of the best in the market. With moderate to high usage, the device runs for more than 10 hours. Very good for multimedia usage.</p>
                        </div>
                        <div class="j_sepSlide">
                            <a href="javascript:void(0);">
                                <p>How much does Bajaj Finserv charge for the Bajaj Finserv EMI Network Card?</p>
                                <i class="fa fa-plus"></i>
                            </a>
                            <p class="j_displBlock">The battery back-up of the Apple iPad 32GB is one of the best in the market. With moderate to high usage, the device runs for more than 10 hours. Very good for multimedia usage.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="j_growEmi">
            <h2>Shop hassle-free on India’s fastest growing EMI Network</h2>
            <div class="j_emiNetPic"><img src="{{view url=images/emi-network/growEmi.png}}" alt="">
            <ul class="">
            <li>
            <h4>60k+</h4>
            <p>Partner Stores</p>
            </li>
            <li>
            <h4>1 mn+</h4>
            <p>Happy Customers</p>
            </li>
            <li>
            <h4>1.3k</h4>
            <p>Cities across India</p>
            </li>
            </ul>
            </div>
            </div>
            </div>
            </section>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $this->blockFactory->create()->setData($GetEMINetworkCardBlock)->save();
    }

    /**
     * Create Static Pages
     */
    public function createEmiNetworkPage() {
        $emiNetworkPage = '<div class="maxcontainer">
            {{block id="emi-network-get-card" name="Get EMI Network Card"}} {{block id="emi-network-card-features" name="EMI Network Card Features"}} {{block id="emi-network-feature-categories" name="EMI Network Feature Categories"}} {{block id="emi-network-card-steps" name="EMI Network Card Steps"}} {{block id="emi-network-faqs" name="EMI Network FAQs"}}
            </div>';
        $emiNetworkPageContent = $this->pageFactory->create()->load('emi-network', 'identifier');
        if ($emiNetworkPageContent->getId()) {
            $emiNetworkPageContent->setContent($emiNetworkPage);
            $emiNetworkPageContent->save();
        } else {
            $emiNetworkPageView = [
                'title' => 'Emi Network',
                'identifier' => 'emi-network',
                'page_layout' => '1column',
                'content' => $emiNetworkPage,
                'is_active' => 1,
                'store_id' => [0]
            ];
            $this->pageFactory->create()->setData($emiNetworkPageView)->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies() {
        return [];
    }

    public function revert() {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases() {
        return [];
    }

}
