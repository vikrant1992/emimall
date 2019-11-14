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
use Magento\Cms\Model\BlockFactory;

class CreateCategoryAttributes implements DataPatchInterface {

    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    /** @var  BlockFactory */
    private $blockFactory;
    
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        BlockFactory $blockFactory
            
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'custom_url', [
                'type' => 'varchar',
                'label' => 'Custom URL',
                'input' => 'text',
                'sort_order' => 333,
                'source' => '',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'group' => 'General Information',
                'backend' => ''
        ]);
        
        //create footer cms blocks
            $footerLowerBlock = [
                'title' => 'Footer Main Block',
                'identifier' => 'footer-main-block',
                'content' => '<div class="V_emi-footer">
                    <div class="container">
                    <div class="V_emi-footer-sec">
                    <div class="V_emi-footer-menu">
                    <div class="V_footr-menu">
                    <div class="V_foo-emi"><img src="{{view url="images/footer-logo.png"}}" alt="" class="V_foo-logo"></div>
                    <div class="V_address">
                    <p>4th Floor, Bajaj Finserv Corporate Office,</p>
                    <p>Off Pune-Ahmednagar Road,</p>
                    <p>Viman Nagar, Pune – 411014</p>
                    </div>
                    <div class="V_footercontect"><a href="JavaScript:void(0);"><img src="{{view url="images/footer-call.png"}}" alt="">
                    <p>020 3957 5152</p>
                    </a> <a href="JavaScript:void(0);"> <img src="{{view url="images/footer-mail.png"}}" alt="">
                    <p>wecare@bajajfinserv.in</p>
                    </a></div>
                    <ul class="V_social-list">
                    <li><a href="JavaScript:void(0);"> <img src="{{view url="images/instagram-ico.png"}}" alt=""> </a></li>
                    <li><a href="JavaScript:void(0);"> <img src="{{view url="images/facebookico.png"}}" alt=""> </a></li>
                    <li><a href="JavaScript:void(0);"> <img src="{{view url="images/twitterico.png"}}" alt=""> </a></li>
                    </ul>
                    </div>
                    <div class="V_footr-menu">
                    <div class="V_footerlisting">
                    <ul class="V_footer-menu-lst">
                    <li class="V-explore"><a href="JavaScript:void(0);">Explore bajaj finserv emi mall</a></li>
                    <li><a href="JavaScript:void(0);">Bajaj Finserv EMI Network Card</a></li>
                    <li><a href="JavaScript:void(0);">Fees &amp; Charges</a></li>
                    <li><a href="JavaScript:void(0);">FAQs</a></li>
                    <li><a href="JavaScript:void(0);">Help</a></li>
                    <li><a href="JavaScript:void(0);">Contact Us</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="V_footr-menu">
                    <div class="V_footerlisting">
                    <ul class="V_footer-menu-lst">
                    <li class="V-explore"><a href="JavaScript:void(0);">companies</a></li>
                    <li><a href="JavaScript:void(0);">Bajaj Finserv Limited</a></li>
                    <li><a href="JavaScript:void(0);">Bajaj Finance Limited</a></li>
                    <li><a href="JavaScript:void(0);">Bajaj Housing Finance Limited</a></li>
                    <li><a href="JavaScript:void(0);">Bajaj Allianz Life Insurance</a></li>
                    <li><a href="JavaScript:void(0);">Bajaj Allianz General Insurance</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="V_footr-menu">
                    <div class="V_footerlisting">
                    <ul class="V_footer-menu-lst">
                    <li class="V-explore">
                    <p>Bajaj Finance Limited Regd. Office:</p>
                    </li>
                    <li>
                    <p>Akurdi, Pune-411035</p>
                    </li>
                    <li class="V-explore">
                    <p>Bajaj Finance Limited Regd. Office:</p>
                    </li>
                    <li>
                    <p>L65910MH1987PLC042961</p>
                    </li>
                    <li class="V-explore">
                    <p>IRDAI Corporate Agency Registration Number</p>
                    </li>
                    <li>
                    <p>CA0101</p>
                    </li>
                    </ul>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    <div class="V_bottomfooter">
                    <div class="container">
                    <div class="V_copyright">
                    <p>© Bajaj Finserv EMI Mall 2019</p>
                    </div>
                    <div class="V_footerlisting">
                    <ul class="V_footer-menu-lst">
                    <li><a href="JavaScript:void(0);">Privacy Policy</a></li>
                    <li><a href="JavaScript:void(0);">Terms &amp; Conditions</a></li>
                    <li><a href="JavaScript:void(0);">Disclaimer</a></li>
                    <li><a href="JavaScript:void(0);">Grievance Redressal</a></li>
                    </ul>
                    </div>
                    </div>
                    </div>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 0
            ];
            $this->blockFactory->create()->setData($footerLowerBlock)->save();

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