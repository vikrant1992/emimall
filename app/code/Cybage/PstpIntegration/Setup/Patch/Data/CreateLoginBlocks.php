<?php
/**
 * BFL Cybage_PstpIntegration
 *
 * @category   Cybage_PstpIntegration Module
 * @package    BFL Cybage_PstpIntegration
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\PstpIntegration\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Cms\Model\BlockFactory;

class CreateLoginBlocks implements DataPatchInterface {

    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var  BlockFactory */
    private $blockFactory;
    
    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param BlockFactory $blockFactory
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
        $loginOffersBlock = [
                'title' => 'Login Offers Popup',
                'identifier' => 'login-offers-popup',
                'content' => '<div class="congratesPart congOpen1">
                    <div class="cadImg"><img src="{{view url=images/emi_network_card.png}}" alt=""></div>
                    <div class="a_congcon">
                    <h4>Congratulations!<br/> <span class="mobileText">You have a pre-approved amount</span> of Rs.<span class="pre-approved-amount"></span></h4>
                    <p>You can use it to shop for 1 million+ products from any of our 60,000+ partner stores.</p>
                    </div>
                    <div class="buttoPart"><a href="javascript:void(0);" class="btnBlue openofr">Learn How To Avail This Offer</a> <a href="" class="btnLink">Continue Shopping</a></div>
                    </div>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 0
            ];
        $this->blockFactory->create()->setData($loginOffersBlock)->save();
            
        $loginGetPreApprovedOffersBlock = [
                'title' => 'Login Get Pre-approved Offers Popup',
                'identifier' => 'login-get-pre-approved-offers-popup',
                'content' => '<div class="congratesPart congOpen2">
                    <div class="cadImg persentImg"><img src="{{view url=images/persentsImg.svg}}" alt=""></div>
                    <div class="a_congcon">
                    <h4 class="offer-data">Hi <span class="user-name"></span>!<br/> <span class="mobileText">You have</span> Rs.<span class="user-approved-amount"></span> <span class="mobileText">on your</span> EMI Network Card</h4>
                    <p>You can still shop for more than 1 million+ products from any of our 60,000+ partner stores using Bajaj Finserv EMI Network Card.</p>
                    </div>
                    <div class="buttoPart"><a href="" class="btnBlue">Know more about EMI Network Card</a> <a href="javascript:void(0);" class="btnLink">Continue Shopping</a></div>
                    </div>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 1
            ];
        $this->blockFactory->create()->setData($loginGetPreApprovedOffersBlock)->save();
        
        $loginNoPreApprovedOffersBlock = [
                'title' => 'No Pre-approved Offers Popup',
                'identifier' => 'no-pre-approved-offers-popup',
                'content' => '<div class="congratesPart congOpen3">
                    <div class="cadImg"><img src="{{view url=images/emi_network_card.png}}" alt=""></div>
                    <div class="a_congcon">
                    <h4>You don\'t <span class="mobileText">have any<br/> pre-approved</span> offer... yet</h4>
                    <p>You can still shop for more than 1 million+ products from any of our 60,000+ partner stores.</p>
                    </div>
                    <div class="buttoPart"><a href="" class="btnBlue">Continue Shopping</a> <a href="javascript:void(0);" class="btnLink">Find a store near you</a></div>
                    </div>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 0
            ];
        $this->blockFactory->create()->setData($loginNoPreApprovedOffersBlock)->save();
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