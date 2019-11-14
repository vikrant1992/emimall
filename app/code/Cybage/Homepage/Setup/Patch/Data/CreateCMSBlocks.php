<?php
/**
 * BFL Cybage_Homepage
 *
 * @category   Cybage_Homepage Module
 * @package    BFL Cybage_Homepage
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\Homepage\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\BlockFactory;

/**
 */
class CreateCMSBlocks implements DataPatchInterface, PatchRevertableInterface {

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
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        PageFactory $pageFactory,
        BlockFactory $blockFactory
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
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->createHomepageBlocks();
        $this->createHomePage();
        $this->moduleDataSetup->getConnection()->endSetup();
    }
    
    /**
     * Create Home Page
     */
    public function createHomePage()
    {
        $homePageContent = '<div class="maxcontainer">{{block class="Magento\Cms\Block\Block" block_id="homepage-main-banner"}}
            {{block class="Magento\Framework\View\Element\Template" template="Magento_Theme::homepage/search-mobile-view.phtml"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-item-category"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-mobilesdeals"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-after-main-banner"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-products-on-easy-emi"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-shop-by-emi-range"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-mobilesdeals"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-after-shop-by-emi-range"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-shoppopulartv"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-mobilesdeals"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-featuredcollection"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-after-featured-categories"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-mobilesdeals"}}
            {{block class="Cybage\Homepage\Block\Product\Details" template="Cybage_Homepage::product/quick-compare.phtml"}}
            {{block class="Magento\Cms\Block\Block" block_id="homepage-shopEMI"}}
            <div class="transparentBackground">&nbsp;</div>
            </div>';
        $homePage = $this->pageFactory->create()->load('home','identifier');
        if ($homePage->getId()) {
            $homePage->setContent($homePageContent);
            $homePage->save();
        }else{
            $newHomePage = [
                'title' => 'Home page',
                'identifier' => 'home',
                'page_layout' => '1column',
                'content' => $homePageContent,
                'is_active' => 1,
                'store_id' => [0]
            ];
            $this->pageFactory->create()->setData($newHomePage)->save();
        }
    }
    
    /**
     * Create HomePage Blocks
     */
    public function createHomepageBlocks() {
            //Main Banner Block
            $mainBannerBlock = [
                'title' => 'Homepage Main Banner',
                'identifier' => 'homepage-main-banner',
                'content' => '<section class="p_homebannerpart desktopBanner">
                    <div class="p_bannerdesignhome"><img src="{{view url=images/homebanner.png}}" alt="homebanner">
                    <div class="p_bannerhometext">
                    <h1>Get any product you need on EMI.</h1>
                    <p>Looking to buy something on a budget?</p>
                    <a href="javascript:void(0)">Shop on Easy EMIs <img src="{{view url=images/arrow-right-green.svg}}" alt="arrow-right-green"></a></div>
                    </div>
                    </section>
                    <section class="p_homebannerpart mobileBanner">
                    <div class="p_bannerdesignhome"><img src="{{view url=images/homebanner.png}}" alt="homebanner">
                    <div class="p_bannerhometext">
                    <h1>Get any product you need on EMI.</h1>
                    <p>Looking to buy something on a budget?</p>
                    <a href="javascript:void(0)">Shop on Easy EMIs <img src="{{view url=images/arrow-right-green.svg}}" alt="arrow-right-green"></a></div>
                    </div>
                    </section>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 0
            ];
            $this->blockFactory->create()->setData($mainBannerBlock)->save();

            // After Main Banner Block
            $afterMainBannerBlock = [
                'title' => 'Homepage After Main Banner',
                'identifier' => 'homepage-after-main-banner',
                'content' => '<section class="p_appleiphone">
                    <div class="p_leftpaddslide">
                    <div class="p_titlehome">
                    <div class="p_lefttext">
                    <h2>Apple iPhones</h2>
                    <strong>Starting at <i class="fa fa-rupee"></i> 1,299/month</strong>
                    </div>
                    <a href="{{store url=&quot;mobiles-and-electronics/mobiles.html&quot;}}" class="topmarViewAll">View All</a></div>
                    </div>
                    {{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Cybage_Homepage::product/widget/content/grid.phtml" title="Apple iPhones" show_pager="0" products_count="10" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`26`^]^]" type_name="Catalog Products List"}}
                    </section>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 1
            ];
            $this->blockFactory->create()->setData($afterMainBannerBlock)->save();
            
            //Products on Easy EMI Block
            $productsOnEasyEMIBlock = [
                'title' => 'Homepage Products on Easy EMI',
                'identifier' => 'homepage-products-on-easy-emi',
                'content' => '<section class="p_appleiphone">
                    <div class="p_leftpaddslide">
                    <div class="p_titlehome">
                    <div class="p_lefttext">
                    <h2 class="laptopsEmi">Laptops on Easy EMIs</h2>
                    </div>
                    <a href="{{store url=&quot;mobiles-and-electronics/mobiles.html&quot;}}">View All</a></div>
                    </div>
                    {{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Cybage_Homepage::product/widget/content/grid.phtml" title="Laptops on Easy EMIs" show_pager="0" products_count="10" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`26`^]^]" type_name="Catalog Products List"}}</section>
                    <section class="p_moresamerphone">
                    <div class="p_leftpaddslide">
                    <div class="p_smartphonepart">
                    <div class="p_smartphonepartspecing">
                    <div class="p_samrtphonetext">
                    <p>More on Laptops</p>
                    </div>
                    <div class="p_pricebtn">
                    <ul class="smertphonebtn">
                    <li><a href="javascript:void(0)">Under
                    <p class="fa fa-rupee"></p>
                    999</a></li>
                    <li><a href="javascript:void(0)">Bestsellers</a></li>
                    <li><a href="javascript:void(0)">AI Camera Phones</a></li>
                    <li><a href="javascript:void(0)">Snapdragon 855</a></li>
                    <li><a href="javascript:void(0)">Under
                    <div class="fa fa-rupee"></div>
                    999</a></li>
                    </ul>
                    </div>
                    </div>
                    </div>
                    </div>
                    </section>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 2
            ];
            $this->blockFactory->create()->setData($productsOnEasyEMIBlock)->save();
            
            // Shop By EMI Range block
            $shopByEMIRangeBlock = [
                'title' => 'Homepage Shop By EMI Range',
                'identifier' => 'homepage-shop-by-emi-range',
                'content' => '<section class="p_appleiphone shopbyemirange">
                    <div class="p_leftpaddslide">
                    <div class="p_titlehome">
                    <div class="p_lefttextfrist">
                    <h2>Shop by EMI Range</h2>
                    </div>
                    </div>
                    <div class="p_startingpricce">
                    <ul class="p_priceinside">
                    <li class="active"><a data-emirange="emirange-999" data-url="mobiles-and-electronics/mobiles.html?emi_starting_at=0-999">Under
                    <div class="fa fa-rupee"></div>
                    999</a></li>
                    <li><a data-emirange="emirange-2500" data-url="mobiles-and-electronics/mobiles.html?emi_starting_at=0-2500">Under
                    <div class="fa fa-rupee"></div>
                    2500</a></li>
                    <li><a data-emirange="emirange-4500" data-url="mobiles-and-electronics/mobiles.html?emi_starting_at=0-4500">Under
                    <div class="fa fa-rupee"></div>
                    4500</a></li>
                    <li><a data-emirange="emirange-5500" data-url="mobiles-and-electronics/mobiles.html?emi_starting_at=0-5500">Under
                    <div class="fa fa-rupee"></div>
                    5500</a></li>
                    <li><a data-emirange="emirange-8500" data-url="mobiles-and-electronics/mobiles.html?emi_starting_at=0-8500">Under
                    <div class="fa fa-rupee"></div>
                    8500</a></li>
                    <li><a data-emirange="emirange-10000" data-url="mobiles-and-electronics/mobiles.html?emi_starting_at=0-10000">Under
                    <div class="fa fa-rupee"></div>
                    10,000</a></li>
                    <li><a data-emirange="emirange-10000" data-url="mobiles-and-electronics/mobiles.html?emi_starting_at=0-10000">Under
                    <div class="fa fa-rupee"></div>
                    10,000</a></li>
                    </ul>
                    </div>
                    </div>
                    <div id="emirange-999" class="showproducts">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Cybage_Homepage::product/widget/content/grid.phtml" show_pager="0" 
                        products_count="10" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--3`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`26`^]^]" type_name="Catalog Products List"}}</div>
                    <div id="emirange-2500" class="hideproducts">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Cybage_Homepage::product/widget/content/grid.phtml" show_pager="0" 
                        products_count="10" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--3`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`26`^]^]" type_name="Catalog Products List"}}</div>
                    <div id="emirange-4500" class="hideproducts">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Cybage_Homepage::product/widget/content/grid.phtml" show_pager="0" 
                        products_count="10" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--3`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`26`^]^]" type_name="Catalog Products List"}}</div>
                    <div id="emirange-5500" class="hideproducts">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Cybage_Homepage::product/widget/content/grid.phtml" show_pager="0" 
                        products_count="10" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`emi_starting_at`,`operator`:`^)=`,`value`:`0`^],`1--2`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`emi_starting_at`,`operator`:`^(=`,`value`:`1000`^],`1--3`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`26`^]^]" type_name="Catalog Products List"}}</div>
                    <div id="emirange-8500" class="hideproducts">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Cybage_Homepage::product/widget/content/grid.phtml" show_pager="0" 
                        products_count="10" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`emi_starting_at`,`operator`:`^)=`,`value`:`0`^],`1--2`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`emi_starting_at`,`operator`:`^(=`,`value`:`150`^],`1--3`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`40`^]^]" type_name="Catalog Products List"}}</div>
                    <div id="emirange-10000" class="hideproducts">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Cybage_Homepage::product/widget/content/grid.phtml" show_pager="0" 
                        products_count="10" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`emi_starting_at`,`operator`:`^)=`,`value`:`0`^],`1--2`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`emi_starting_at`,`operator`:`^(=`,`value`:`150`^],`1--3`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`40`^]^]" type_name="Catalog Products List"}}</div>
                    <div class="p_viewallunder"><a href="{{store url=&quot;mobiles-and-electronics/mobiles.html?emi_starting_at=0-999&quot;}}">View all products under <i class="fa fa-rupee"></i> 999 &gt;</a></div>
                    </section>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 3
            ];
            $this->blockFactory->create()->setData($shopByEMIRangeBlock)->save();
            
            //After Shop By EMI Range
            $afterShopByEMIRangeBlock = [
                'title' => 'Homepage After Shop By EMI Range',
                'identifier' => 'homepage-after-shop-by-emi-range',
                'content' => '<section class="p_appleiphone">
                    <div class="p_leftpaddslide">
                    <div class="p_titlehome">
                    <div class="p_lefttext">
                    <h2 class="laptopsEmi">Smart TVs</h2>
                    </div>
                    <a href="{{store url=&quot;mobiles-and-electronics/mobiles.html&quot;}}">View All</a></div>
                    </div>
                    {{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Cybage_Homepage::product/widget/content/grid.phtml" 
                        show_pager="0" products_count="10" 
                        conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`25`^]^]" 
                        type_name="Catalog Products List"}}
                    </section>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 4
            ];
            $this->blockFactory->create()->setData($afterShopByEMIRangeBlock)->save();
            
            //Shop Popular TV Block
            $shopPopularTvBlock = [
                'title' => 'Home Page Shop Popular TV',
                'identifier' => 'homepage-shoppopulartv',
                'content' => '<section class="p_screensize">
                    <div class="p_leftpaddslide">
                    <div class="p_titlehome">
                    <div class="p_lefttext">
                    <h2>Shop TVs by</h2>
                    <strong>Popular Screen Sizes</strong>
                    </div>
                    </div>
                    <div class="p_inchbox">
                    <ul class="inchscreen">
                    <li><a href="javascript:void(0);">30"
                    <p>TVs</p>
                    </a></li>
                    <li><a href="javascript:void(0);">32"
                    <p>TVs</p>
                    </a></li>
                    <li><a href="javascript:void(0);">40"
                    <p>TVs</p>
                    </a></li>
                    <li><a href="javascript:void(0);">43"
                    <p>TVs</p>
                    </a></li>
                    <li><a href="javascript:void(0);">50"
                    <p>TVs</p>
                    </a></li>
                    <li><a href="javascript:void(0);">60"
                    <p>TVs</p>
                    </a></li>
                    <li><a href="javascript:void(0);">65"
                    <p>TVs</p>
                    </a></li>
                    <li><a href="javascript:void(0);">70"
                    <p>TVs</p>
                    </a></li>
                    <li><a href="javascript:void(0);">75"
                    <p>TVs</p>
                    </a></li>
                    <li><a href="javascript:void(0);">80"
                    <p>inch</p>
                    </a></li>
                    </ul>
                    </div>
                    </div>
                    </section>
                    <section class="p_moresamerphone">
                    <div class="p_leftpaddslide">
                    <div class="p_smartphonepart">
                    <div class="p_smartphonepartspecing">
                    <div class="p_samrtphonetext">
                    <p>More on televisions</p>
                    </div>
                    <div class="p_pricebtn">
                    <ul class="smertphonebtn">
                    <li><a href="javascript:void(0);">Full HD 4K</a></li>
                    <li><a href="javascript:void(0);">Bestsellers</a></li>
                    <li><a href="javascript:void(0);">TVs Under 20,000</a></li>
                    <li><a href="javascript:void(0);">Android TVs</a></li>
                    <li><a href="javascript:void(0);">Full HD 4K</a></li>
                    </ul>
                    </div>
                    </div>
                    </div>
                    </div>
                    </section>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 5
            ];
            $this->blockFactory->create()->setData($shopPopularTvBlock)->save();
            
            //Featured Categories Block
            $fraturedCategoriesBlock = [
                'title' => 'Home Page Featured Collection',
                'identifier' => 'homepage-featuredcollection',
                'content' => '<section class="p_futuchercat">
                    <div class="p_leftandright">
                    <div class="p_titlefutucher">
                    <h2>Featured Categories</h2>
                    <a href="javascript:void(0);">View All</a></div>
                    <div class="p_catlistfutucher">
                    <ul>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg1.png}}" src="" alt="topimg1"></div>
                    <p>Smartphones</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg2.png}}" src="" alt="topimg2"></div>
                    <p>Laptops</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg3.png}}" src="" alt="topimg3"></div>
                    <p>Refrigerators</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg4.png}}" src="" alt="topimg4"></div>
                    <p>Speakers</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg5.png}}" src="" alt="topimg5"></div>
                    <p>Washing Machines</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg6.png}}" src="" alt="topimg6"></div>
                    <p>Televisions</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" src="{{view url=images/topimg2.png}}" data-src="{{view url=images/topimg4.png}}" src="" alt="topimg4"></div>
                    <p>Speakers</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg2.png}}" src="" alt="topimg2"></div>
                    <p>Laptops</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg1.png}}" src="" alt="topimg1"></div>
                    <p>Printers</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg2.png}}" src="" alt="topimg2"></div>
                    <p>Smartphones</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg3.png}}" src="" alt="topimg3"></div>
                    <p>Smart Watches</p>
                    </a></li>
                    <li><a href="javascript:void(0);">
                    <div class="p_catlistbg"><img class="lazy" src="{{view url=images/frame-landscape.png}}" data-src="{{view url=images/topimg4.png}}" src="" alt="topimg4"></div>
                    <p>Gaming PC</p>
                    </a></li>
                    </ul>
                    </div>
                    </div>
                    </section>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 6
            ];
            $this->blockFactory->create()->setData($fraturedCategoriesBlock)->save();
            
            //After Featured Categories Block
            $afterfeaturedCategoriesBlock = [
                'title' => 'Homepage After Featured Categories',
                'identifier' => 'homepage-after-featured-categories',
                'content' => '<section class="p_appleiphone">
                    <div class="p_leftpaddslide">
                    <div class="p_titlehome">
                    <div class="p_lefttext">
                    <h2>Washing Machines</h2>
                    <strong>Starting at <i class="fa fa-rupee"></i> 1,299/month</strong>
                    </div>
                    <a href="javascript:void(0);" class="topmarViewAll">View All</a></div>
                    </div>
                    {{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Cybage_Homepage::product/widget/content/grid.phtml" 
                        show_pager="0" products_count="10" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`24`^]^]" type_name="Catalog Products List"}}</section>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 7
            ];
            $this->blockFactory->create()->setData($afterfeaturedCategoriesBlock)->save();
            
            //Shop On Easy EMI Block
            $shopOnEasyEMIBlock = [
                'title' => 'Home Page Shop EMI',
                'identifier' => 'homepage-shopEMI',
                'content' => '<div class="shoponEasyEmiPopUp">
                    <div class="backsript"><a href="javascript:void(0);"><img src="{{view url=images/back.png}}" alt="back"></a></div>
                    <h2>Shop on Easy EMIs</h2>
                    <div class="slctCategory">
                    <h3>Select a category</h3>
                    <ul>
                    <li><a class="active" href="javascript:void(0);" data-category="Smartphones" data-label="Smartphones" data-url="mobiles-and-electronics/mobiles.html">Smartphones</a></li>
                    <li><a data-category="Laptops" data-label="Laptops" data-url="mobiles-and-electronics/laptops.html">Laptops</a></li>
                    <li><a data-category="Refrigerators" data-label="Refrigerators" data-url="mobiles-and-electronics/laptops.html">Refrigerators</a></li>
                    <li><a data-category="AirConditioners" data-label="Air Conditioners" data-url="mobiles-and-electronics/laptops.html">Air Conditioners</a></li>
                    <li><a data-category="WashingMachines" data-label="Washing Machines" data-url="mobiles-and-electronics/laptops.html">Washing Machines</a></li>
                    <li><a data-category="Tablets" data-label="Tablets" data-url="mobiles-and-electronics/laptops.html">Tablets</a></li>
                    <li><a data-category="Speakers" data-label="Speakers" data-url="mobiles-and-electronics/laptops.html">Speakers</a></li>
                    <li><a data-category="Televisions" data-label="Televisions" data-url="mobiles-and-electronics/laptops.html">Televisions</a></li>
                    <li><a class="more">3+</a></li>
                    <li class="showonmore"><a data-category="Tablets" data-label="Tablets" data-url="mobiles-and-electronics/laptops.html">Tablets</a></li>
                    <li class="showonmore"><a data-category="Speakers" data-label="Speakers" data-url="mobiles-and-electronics/laptops.html">Speakers</a></li>
                    <li class="showonmore"><a data-category="Televisions" data-label="Televisions" data-url="mobiles-and-electronics/laptops.html">Televisions</a></li>
                    </ul>
                    </div>
                    <div class="slctEmirange">
                    <h3>Select EMI range</h3>
                    <ul id="Smartphones" class="showEmirange">
                    <li><a class="active" data-value="500-1500">500 - 1,500</a></li>
                    <li><a data-value="1500-2500">1,500 - 2,500</a></li>
                    <li><a data-value="2500-3500">2,500 - 3,500</a></li>
                    </ul>
                    <ul id="Laptops" class="hideEmirange">
                    <li><a class="active" data-value="15000-25000"> 15,000-25,000</a></li>
                    <li><a data-value="25000-35000">25,000-35,000</a></li>
                    <li><a data-value="35000-45000">35,000-45,000</a></li>
                    </ul>
                    <ul id="Refrigerators" class="hideEmirange">
                    <li><a class="active" data-value="5000-10000">5000 - 10,000</a></li>
                    <li><a data-value="10000-15000">10,000 - 15,000</a></li>
                    <li><a data-value="15000-20000">15,000 - 20,000</a></li>
                    </ul>
                    <ul id="AirConditioners" class="hideEmirange">
                    <li><a class="active" data-value="5000-10000">5000 - 10,000</a></li>
                    <li><a data-value="10000-15000">10,000 - 15,000</a></li>
                    <li><a data-value="15000-20000">15,000 - 20,000</a></li>
                    </ul>
                    <ul id="Tablets" class="hideEmirange">
                    <li><a class="active" href="javascript:void(0);">500 - 1,500</a></li>
                    <li><a>1,500 - 2,500</a></li>
                    <li><a>2,500 - 3,500</a></li>
                    </ul>
                    <ul id="Speakers" class="hideEmirange">
                    <li><a class="active">500 - 1,500</a></li>
                    <li><a>1,500 - 2,500</a></li>
                    <li><a>2,500 - 3,500</a></li>
                    </ul>
                    <ul id="Televisions" class="hideEmirange">
                    <li><a class="active">500 - 1,500</a></li>
                    <li><a>1,500 - 2,500</a></li>
                    <li><a>2,500 - 3,500</a></li>
                    </ul>
                    <ul id="WashingMachines" class="hideEmirange">
                    <li><a class="active">500 - 1,500</a></li>
                    <li><a>1,500 - 2,500</a></li>
                    <li><a>2,500 - 3,500</a></li>
                    </ul>
                    </div>
                    <a class="findcta" href="javascript:void(0)">Find Smartphones</a></div>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 8
            ];
            $this->blockFactory->create()->setData($shopOnEasyEMIBlock)->save();
            
            //Homepage Mobile Deals Block
            $mobileDealsBlock = [
                'title' => 'Homepage Mobiles Deals',
                'identifier' => 'homepage-mobilesdeals',
                'content' => '<section class="p_dealsonleptop">
                    <div class="p_leftpaddslide">
                    <div class="p_laptopbord">
                    <ul class="laptopbrend">
                    <li><a href="#;"> <img src="{{view url=images/iphonetext.png}}" alt="iphonetext">
                    <div class="P_iphonereview">
                    <strong>iPhone XS</strong>
                    <p>EMI starting @ 1,299/mo</p>
                    </div>
                    </a></li>
                    <li><a href="#;"> <img src="{{view url=images/iphonetext.png}}" alt="iphonetext">
                    <div class="P_iphonereview">
                    <strong>iPhone XS</strong>
                    <p>EMI starting @ 1,299/mo</p>
                    </div>
                    </a></li>
                    <li><a href="#;"> <img src="{{view url=images/iphonetext.png}}" alt="iphonetext">
                    <div class="P_iphonereview">
                    <strong>iPhone XS</strong>
                    <p>EMI starting @ 1,299/mo</p>
                    </div>
                    </a></li>
                    <li><a href="#;"> <img src="{{view url=images/iphonetext.png}}" alt="iphonetext">
                    <div class="P_iphonereview">
                    <strong>iPhone XS</strong>
                    <p>EMI starting @ 1,299/mo</p>
                    </div>
                    </a></li>
                    </ul>
                    </div>
                    </div>
                    </section>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 9
            ];
            $this->blockFactory->create()->setData($mobileDealsBlock)->save();
            
            //Homepage Item Categories for Mobile view
            $iemCategoriesForMobileBlock = [
                'title' => 'Home Page Item Category',
                'identifier' => 'homepage-item-category',
                'content' => '<section class="p_itemcatgoery">
                    <div class="p_leftpaddslide">
                    <div class="p_samertmobile">
                    <ul class="smertphone">
                    <li><a href="#;">
                    <div class="p_samrtbg"><img src="{{view url=images/topimg1.png}}" alt=""></div>
                    <p>Smartphones</p>
                    </a></li>
                    <li><a href="#;">
                    <div class="p_samrtbg"><img src="{{view url=images/topimg2.png}}" alt=""></div>
                    <p>Laptops</p>
                    </a></li>
                    <li><a href="#;">
                    <div class="p_samrtbg"><img src="{{view url=images/topimg3.png}}" alt=""></div>
                    <p>Tablets</p>
                    </a></li>
                    <li><a href="#;">
                    <div class="p_samrtbg"><img src="{{view url=images/topimg4.png}}" alt=""></div>
                    <p>Televisions</p>
                    </a></li>
                    <li><a href="#;">
                    <div class="p_samrtbg"><img src="{{view url=images/topimg5.png}}" alt=""></div>
                    <p>Refrigerators</p>
                    </a></li>
                    <li><a href="#;">
                    <div class="p_samrtbg"><img src="{{view url=images/topimg1.png}}" alt=""></div>
                    <p>Smartphones</p>
                    </a></li>
                    <li><a href="#;">
                    <div class="p_samrtbg"><img src="{{view url=images/topimg2.png}}" alt=""></div>
                    <p>Laptops</p>
                    </a></li>
                    <li><a href="#;">
                    <div class="p_samrtbg"><img src="{{view url=images/topimg3.png}}" alt=""></div>
                    <p>Tablets</p>
                    </a></li>
                    <li><a href="#;">
                    <div class="p_samrtbg"><img src="{{view url=images/topimg4.png}}" alt=""></div>
                    <p>Televisions</p>
                    </a></li>
                    <li><a href="#;">
                    <div class="p_samrtbg"><img src="{{view url=images/topimg5.png}}" alt=""></div>
                    <p>Refrigerators</p>
                    </a></li>
                    </ul>
                    </div>
                    </div>
                    </section>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 10
            ];
            $this->blockFactory->create()->setData($iemCategoriesForMobileBlock)->save();
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