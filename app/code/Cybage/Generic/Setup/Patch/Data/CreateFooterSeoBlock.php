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

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Cms\Model\BlockFactory;

class CreateFooterSeoBlock implements DataPatchInterface {

    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var  BlockFactory */
    private $blockFactory;
    
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        BlockFactory $blockFactory
            
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $menuBannerBlock = [
                'title' => 'Footer Seo Block',
                'identifier' => 'footer-seo-block',
                'content' => '<div class="a_colapsFoot">
                    <p>Explore Bajaj Finserv EMI Mall</p>
                    <i class="fas fa-angle-down"></i></div>
                    <div class="a_footerWhite">
                    <div class="container">
                    <h4 class="a_footMainttl">Didn’t find what you were looking for? Try these</h4>
                    <div class="a_fBallIn">
                    <div class="a_footerBlock">
                    <strong>popular searches</strong>
                    <div class="a_frow10">
                    <ul>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="a_footerBlock">
                    <strong>mobile phones</strong>
                    <div class="a_frow10">
                    <ul>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="a_footerBlock">
                    <strong>laptops</strong>
                    <div class="a_frow10">
                    <ul>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="a_footerBlock">
                    <strong>televisions</strong>
                    <div class="a_frow10">
                    <ul>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="a_footerBlock">
                    <strong>refrigerators</strong>
                    <div class="a_frow10">
                    <ul>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="a_footerBlock">
                    <strong>washing machines</strong>
                    <div class="a_frow10">
                    <ul>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="a_footerBlock">
                    <strong>tablets</strong>
                    <div class="a_frow10">
                    <ul>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="a_footerBlock">
                    <strong>air conditioners</strong>
                    <div class="a_frow10">
                    <ul>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    <li><a>iphone X</a></li>
                    <li><a>Lenovo ideapad 500</a></li>
                    <li><a>Redmi Note 7S</a></li>
                    <li><a>Google Pixel 3A</a></li>
                    <li><a>Google Pixel 3A XL</a></li>
                    <li><a>RealMe C2</a></li>
                    <li><a>Realme 3 Pro</a></li>
                    <li><a>Fitbit Inspire HR</a></li>
                    <li><a>Fitbit Versa Lite</a></li>
                    <li><a>Akshaya Tritiya Offers</a></li>
                    <li><a>Fitbit Inspire</a></li>
                    <li><a>Vivo V15</a></li>
                    <li><a>Redmi Go</a></li>
                    <li><a>Redmi note 7 pro</a></li>
                    <li><a>Realme 3</a></li>
                    <li><a>DIR-819 Router</a></li>
                    <li><a>Redmi Note 7</a></li>
                    </ul>
                    </div>
                    </div>
                    </div>
                    <div class="a_fBallInTwo">
                    <div class="a_footerBlock">
                    <h2>Bajaj Finserv EMI Mall</h2>
                    <p>Bajaj Finserv Direct Limited ("BFDL"), erstwhile Bajaj Financial Holdings Limited is a registered corporate agent of Bajaj Allianz Life Insurance Company Limited and Bajaj Allianz General Insurance Company Limited under the IRDAI composite registration number CA0551 valid till 10-Apr-2021. BFDL also renders services to Bajaj Finance Limited (‘BFL’) and Bajaj Housing Finance Limited (‘BHFL’) (referred hereinafter as ‘Lending Partner’) in sourcing of customers, providing preliminary credit support activities, fulfilment services and post-acquisition customer services related to lending business. Registered Office: Bajaj Auto Limited Complex, Mumbai – Pune Road, Akurdi, Pune</p>
                    </div>
                    <div class="a_footerBlock">
                    <h2>Everything on EMI. All in one place</h2>
                    <p>Convert all your big purchases into EMIs of your choice in just 3 simple steps</p>
                    <ul>
                    <li>Search for your product from a list of categories we offer</li>
                    <li>Compare the chosen product for EMI offers, schemes and features</li>
                    <li>Purchase the product from our online EMI Store or Partner Stores</li>
                    </ul>
                    </div>
                    </div>
                    <div class="a_fBallInThree">
                    <div class="a_footerBlock">
                    <h2>Mobile Phones</h2>
                    <p>From budget phones to state-of-the-art smartphones, we have a mobile for everybody out there. Whether you are looking for larger, fuller screens, power-packed batteries, blazing-fast processors, beautification apps, high-tech selfie cameras or just large internal space, we take care of all the essentials. Shop from top brands in the country like Samsung, Apple, Oppo, Xiaomi, Realme, Vivo, and Honor to name a few. Rest assured, youre buying from only the most reliable names in the market. What’s more, with Flipkart’s Complete Mobile Protection Plan, you will never again find the need to run around service centres. This plan entails you to a number of post-purchase solutions, starting at as low as Rupees 99 only! Broken screens, liquid damage to phone, hardware and software glitches, and replacements - the Flipkart Complete Mobile Protection covers a comprehensive range of post-purchase problems, with door-to-door services.</p>
                    </div>
                    <div class="a_footerBlock">
                    <h2>Laptops</h2>
                    <p>When it comes to laptops, we are not far behind. Filter among dozens of super-fast operating systems, hard disk capacity, RAM, lifestyle, screen size and many other criterias for personalized results in a flash. All you students out there, confused about what laptop to get? Our Back To College Store segregates laptops purpose wise (gaming, browsing and research, project work, entertainment, design, multitasking) with recommendations from top brands and industry experts, facilitating a shopping experience that is quicker and simpler.</p>
                    </div>
                    <div class="a_footerBlock">
                    <h2>Televisions</h2>
                    <p>Sleek TVs, power-saving refrigerators, rapid-cooling ACs, resourceful washing machines - discover everything you need to run a house under one roof. Our Dependable TV and Appliance Store ensures zero transit damage, with a replacement guarantee if anything goes wrong; delivery and installation as per your convenience and a double warranty (Official Brand Warranty along with an extended Flipkart Warranty) - rest assured, value for money is what is promised and delivered. Shop from market leaders in the country like Samsung, LG, Whirlpool, Midea, Mi, Vu, Panasonic, Godrej, Sony, Daikin, and Hitachi among many others.</p>
                    </div>
                    <div class="a_footerBlock">
                    <h2>Washing Machines</h2>
                    <p>From budget phones to state-of-the-art smartphones, we have a mobile for everybody out there. Whether you’re looking for larger, fuller screens, power-packed batteries, blazing-fast processors, beautification apps, high-tech selfie cameras or just large internal space, we take care of all the essentials. Shop from top brands in the country like Samsung, Apple, Oppo, Xiaomi, Realme, Vivo, and Honor to name a few. Rest assured, you’re buying from only the most reliable names in the market. What’s more, with Flipkart’s Complete Mobile Protection Plan, you will never again find the need to run around service centres. This plan entails you to a number of post-purchase solutions, starting at as low as Rupees 99 only! Broken screens, liquid damage to phone, hardware and software glitches, and replacements - the Flipkart Complete Mobile Protection covers a comprehensive range of post-purchase problems, with door-to-door services.</p>
                    </div>
                    <div class="a_footerBlock">
                    <h2>Refrigerators</h2>
                    <p>When it comes to laptops, we are not far behind. Filter among dozens of super-fast operating systems, hard disk capacity, RAM, lifestyle, screen size and many other criterias for personalized results in a flash. All you students out there, confused about what laptop to get? Our Back To College Store segregates laptops purpose wise (gaming, browsing and research, project work, entertainment, design, multitasking) with recommendations from top brands and industry experts, facilitating a shopping experience that is quicker and simpler.</p>
                    </div>
                    <div class="a_footerBlock">
                    <h2>Air Conditioners</h2>
                    <p>Sleek TVs, power-saving refrigerators, rapid-cooling ACs, resourceful washing machines - discover everything you need to run a house under one roof. Our Dependable TV and Appliance Store ensures zero transit damage, with a replacement guarantee if anything goes wrong; delivery and installation as per your convenience and a double warranty (Official Brand Warranty along with an extended Flipkart Warranty) - rest assured, value for money is what is promised and delivered. Shop from market leaders in the country like Samsung, LG, Whirlpool, Midea, Mi, Vu, Panasonic, Godrej, Sony, Daikin, and Hitachi among many others.</p>
                    </div>
                    </div>
                    </div>
                    </div>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 0
            ];
            $this->blockFactory->create()->setData($menuBannerBlock)->save();

    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}