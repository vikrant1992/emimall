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
class CreateStaticPagesAndBlocks implements DataPatchInterface, PatchRevertableInterface {

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
        $this->createStaticBlocks();
        $this->createStaticPages();
        $this->moduleDataSetup->getConnection()->endSetup();
    }
    
    /**
     * Create Static Blocks
     */
    public function createStaticBlocks() {
            //Main Banner Block
            $footerMainBlock = $this->blockFactory->create()->load('footer-main-block','identifier');
            $footerMainBlockContent = '<div class="V_emi-footer"><div class="container"><div class="V_emi-footer-sec"><div class="V_emi-footer-menu">
                <div class="V_footr-menu"><div class="V_foo-emi"><img src="{{view url=images/footer-logo.png}}" alt="footer-logo" class="V_foo-logo"></div>
                <div class="V_address"><p>4th Floor, Bajaj Finserv Corporate Office,</p><p>Off Pune-Ahmednagar Road,</p><p>Viman Nagar, Pune – 411014</p>
                </div><div class="V_footercontect"><a><img src="{{view url=images/footer-call.png}}" alt="footer-call"><p>020 3957 5152</p>
                </a> <a> <img src="{{view url=images/footer-mail.png}}" alt="footer-mail"><p>wecare@bajajfinserv.in</p></a></div>
                <ul class="V_social-list"><li><a> <img src="{{view url=images/instagram-ico.png}}" alt=""> </a></li><li><a> <img src="{{view url=&quot;images/facebookico.png}}" alt=""> </a></li>
                <li><a> <img src="{{view url=images/twitterico.png}}" alt="footer-twiteer"> </a></li></ul></div><div class="V_footr-menu">
                <div class="V_footerlisting"><ul class="V_footer-menu-lst"><li class="V-explore"><a>Explore bajaj finserv emi mall</a></li>
                <li><a>Bajaj Finserv EMI Network Card</a></li><li><a>Fees &amp; Charges</a></li><li><a>FAQs</a></li><li><a>Help</a></li>
                <li><a>Contact Us</a></li></ul></div></div><div class="V_footr-menu"><div class="V_footerlisting"><ul class="V_footer-menu-lst">
                <li class="V-explore"><a>companies</a></li><li><a>Bajaj Finserv Limited</a></li><li><a>Bajaj Finance Limited</a></li>
                <li><a>Bajaj Housing Finance Limited</a></li><li><a>Bajaj Allianz Life Insurance</a></li><li><a>Bajaj Allianz General Insurance</a></li>
                </ul></div></div><div class="V_footr-menu"><div class="V_footerlisting"><ul class="V_footer-menu-lst">
                <li class="V-explore"><p>Bajaj Finance Limited Regd. Office:</p></li><li><p>Akurdi, Pune-411035</p></li>
                <li class="V-explore"><p>Bajaj Finance Limited Regd. Office:</p></li><li><p>L65910MH1987PLC042961</p>
                </li><li class="V-explore"><p>IRDAI Corporate Agency Registration Number</p></li>
                <li><p>CA0101</p></li></ul></div></div></div>
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
                <li><a href="/privacy-policy">Privacy Policy</a></li>
                <li><a href="/terms-and-conditions">Terms &amp; Conditions</a></li>
                <li><a href="/disclaimer">Disclaimer</a></li>
                <li><a href="/grievance-redressal">Grievance Redressal</a></li>
                </ul>
                </div>
                </div>
                </div>';
            if ($footerMainBlock->getId()) {
                $footerMainBlock->setContent($footerMainBlockContent);
                $footerMainBlock->save();
            }else{
                $newFooterMainBlock = [
                    'title' => 'Footer Main Block',
                    'identifier' => 'footer-main-block',
                    'content' => $footerMainBlockContent,
                    'is_active' => 1,
                    'store_id' => [0]
                ];
                $this->blockFactory->create()->setData($newFooterMainBlock)->save();
            }
            $termsAndConditionsBlock = [
                'title' => 'Terms and Conditions',
                'identifier' => 'terms-and-conditions',
                'content'=> '<div class="maxcontainer">
                    <section class="p_termcondition">
                    <div class="j_breaDiv">
                    <ul class="bradecrum">
                    <li><a href="javascript:void(0);">Home</a>
                    <p>&gt;</p>
                    </li>
                    <li class="active"><a href="javascript:void(0);">Terms of use</a></li>
                    </ul>
                    </div>
                    <div class="p_termstitle">
                    <h1>TERMS OF USE</h1>
                    </div>
                    <div class="p_termconditiondeta">
                    <div class="p_termtebs">
                    <ul>
                    <li><a class="active" href="terms-and-conditions">Terms of use</a></li>
                    <li><a href="disclaimer">Disclaimer</a></li>
                    <li><a href="privacy-policy">Privacy Policy</a></li>
                    <li><a href="grievance-redressal">Grievance Redressal</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="p_termalldetatext">
                    <div class="p_termlinks">
                    <ul>
                    <li><i>1.</i> <a href="javascript:void(0);" data-tab="overview">OVERVIEW</a></li>
                    <li><i>2.</i> <a href="javascript:void(0);" data-tab="userDec">USER DECLARATION </a></li>
                    <li><i>3.</i> <a href="javascript:void(0);" data-tab="indemity">INDEMNITY</a></li>
                    <li><i>4.</i> <a href="javascript:void(0);" data-tab="material">USE OF MATERIAL AND INFORMATION</a></li>
                    <li><i>5.</i> <a href="javascript:void(0);" data-tab="warranty">NO REPRESENTATION OR WARRANTY</a></li>
                    <li><i>6.</i> <a href="javascript:void(0);" data-tab="limitation">LIMITATION OF LIABILITY</a></li>
                    <li><i>7.</i> <a href="javascript:void(0);" data-tab="property">INTELLECTUAL PROPERTY RIGHTS</a></li>
                    <li><i>8.</i> <a href="javascript:void(0);" data-tab="websites">LINKED WEBSITES</a></li>
                    <li><i>9.</i> <a href="javascript:void(0);" data-tab="governing">GOVERNING LAW</a></li>
                    </ul>
                    </div>
                    <div class="p_termsalltypetext" id="overview">
                    <div class="title_termover">
                    <h2>Overview</h2>
                    </div>
                    <div class="p_inpolicy">
                    <div class="p_termsimpletext">
                    <p>Please read our Terms of Use and Online Privacy Policy carefully.</p>
                    </div>
                    <h2>In this policy,</h2>
                    <ul>
                    <li><i>•</i>
                    <p>“We,�? “us,�? and “our�? means Bajaj Finance Ltd.</p>
                    </li>
                    <li><i>•</i>
                    <p>The “Site�? means this website and an web site, mobile site, or application we provide that includes a link to this Online Privacy Policy;</p>
                    </li>
                    <li><i>•</i>
                    <p>The “Service�? means any information, documents, assistance, or services we may provide to you through our Site or through third party websites or offline channels listed on this Site; and</p>
                    </li>
                    <li><i>•</i>
                    <p>“You�? and “your�? mean anyone who visits, accesses, or uses our Site or obtains Services from us through our Site.</p>
                    </li>
                    </ul>
                    </div>
                    <div class="p_termsimpletext">
                    <p>The services rendered by Bajaj Finance Ltd. are exclusively intended for individuals who are Citizens of India and residing in India. By accessing <a href="javascript:void(0);">www.bajajfinservemimall.in</a> or any pages thereof, and/or using the information provided on or via this Site, you agree to the following terms and conditions. If you do not agree with the terms and conditions stated hereunder, you shall not access, visit and/or use the Service.</p>
                    </div>
                    </div>
                    <div class="p_termsalltypetext" id="userDec">
                    <div class="title_termover">
                    <h2>USER DECLARATION</h2>
                    </div>
                    <div class="p_termsimpletext">
                    <p>By using this Site, you confirm that you are a resident of India and have attained the age of majority to enter into a binding contract and that you are not a person barred from receiving services under the laws of India or other applicable jurisdiction.</p>
                    <p>While using the Site to communicate with Bajaj Finance Ltd., you shall communicate with your registered mobile/telephone number and/or e-mail address. Thereby, you agree to receive communication from Bajaj Finance Ltd. on your registered mobile/telephone number and/or e-mail address.</p>
                    <p>Your accessing this Site and applying/enquiring/verifying any of the products/services offered by Bajaj Finance Ltd. and or you making a request to call back, it is deemed that you have expressly authorized Bajaj Finance Ltd. to call back or send you text messages or messages through Chatbots for solicitation and procurement of various products and services of Bajaj Finance Ltd.. In case if you may not wish to receive any calls/messages, you are obliged to proactively inform Bajaj Finance Ltd. about the same.</p>
                    <p>While using this Site, you agree NOT to, by any means indulge in illegal or unauthorized activities including but not limited to (i) Use the Site for unlawful purposes; (ii) Collect information about the users without their express consent; (iii) Engage in spamming or flooding; (iv) Transmit any software or other materials that contain any virus or other harmful or disruptive component; (v) Remove any copyright, trademark or other proprietary rights notices contained in the Site; (vi) Copy, mirror any part of the Site without our prior permission; (vii) Permit or help anyone without access to use the Site through your username and password or otherwise; and (viii) posting any defamatory messages to either in print/electronic/social media; (ix) Impersonate any person or entity, falsely claim an affiliation with any person or entity, or access the Accounts of others without permission, forge/fabricate another persons’ digital signature, misrepresent the source, identity, or content of information transmitted via the website, perform any other similar fraudulent activity or otherwise send or receive what Bajaj Finance Ltd. reasonably believes to be potentially fraudulent funds; (x) Infringe BAJAJ FINANCE LTD. or any third party’s intellectual property rights, rights of publicity or rights of privacy; (xi) Use any robot, spider, other automatic device, or manual process to monitor or copy the website without prior written permission; (xii) Use any device, software or routine to bypass website exclusion headers, or interfere or attempt to interfere, with the website; (xiii) Remove, circumvent, disable, damage or otherwise interfere with security-related features of the website or features that enforce limitations on the use of the website; (xiv) Reverse engineer, decompile, disassemble or otherwise attempt to discover the source code of the website or any part thereof; (xv) Use the website in any manner that could damage, disable, overburden, or impair it, including but not limited to using website in an automated manner; (xvi) Intentionally interfere with or damage operation of the website or any user’s enjoyment of them, by any means, including but not limited to uploading or otherwise disseminating viruses, adware, spyware, worms, or other malicious code.</p>
                    </div>
                    </div>
                    <div class="p_termsalltypetext" id="indemity">
                    <div class="title_termover">
                    <h2>INDEMNITY</h2>
                    </div>
                    <div class="p_termsimpletext">
                    <p>You agree to indemnify, defend and hold harmless Bajaj Finance Ltd., its Group Companies and their directors, officers, employees, agents, third party service providers, and any other third party providing any service to Bajaj Finance Ltd. in relation to the Services or from whom you avail any product/service and for indulging in any Prohibited conduct as mentioned above whether directly or indirectly, from and against any and all losses, liabilities, claims, damages, costs and expenses (including legal fees and disbursements in connection therewith and interest chargeable thereon) asserted against or incurred by Bajaj Finance Ltd. that arise out of, result from, or may be payable by virtue of, any breach or non-performance of any terms of this Terms of the Usage including any representation, warranty, covenant or agreement made or obligation to be performed by the User pursuant to these terms of usage.</p>
                    </div>
                    </div>
                    <div class="p_termsalltypetext" id="material">
                    <div class="title_termover">
                    <h2>USE OF MATERIAL AND INFORMATION</h2>
                    </div>
                    <div class="p_termsimpletext">
                    <p>The content (material, information, data, news, etc.) contained on this Site is provided for general information only and should not be used as a basis for making business/commercial decisions. Bajaj Finance Ltd. does not provide any advisory services. You are requested to exercise caution and/or seek independent professional advice before purchasing any product, entering any investment or financial obligation based on the Content contained on this Site or any third party websites/applications accessed through this Site or while purchasing any product on any of the offline channels listed on this Site.</p>
                    <p>Images used on this Site and the models photographed in them are for representative purposes only and are not indicative of anyone\'s personal thoughts or ideas.</p>
                    <p>The content on this Site should NOT be regarded as an offer, solicitation, invitation, advice or recommendation to buy or sell financial products / schemes of BAJAJ FINANCE LTD., its Group Companies, Corporate Partners, Subsidiaries or any of its affiliates or to buy any products or services of any third party entities.</p>
                    <p>Products and Services are available only at the discretion of Bajaj Finance Ltd., subject to the individual contractual terms and conditions of the respective Company’s products and services basis which such products &amp; services are offered and such products and services may be withdrawn or amended at any time without notice. In the event of any conflict between the terms and conditions of specific products and services displayed on the Site or third party websites vis-à-vis the terms and conditions laid down by the respective Group/Principal Company (‘Product owner’), the terms and conditions laid down by the Product owner shall prevail.</p>
                    <p>The Site may display links that may direct the You to third party websites. You understand that the use of such third party website shall be in accordance with the terms and conditions and policies governing the said website and Bajaj Finance Ltd. will not be responsible for same.</p>
                    <p>Any information or description of products or services on this Site is for general purposes and Bajaj Finance Ltd. shall not be responsible for the accuracy or completeness of the same or for updating the said information.</p>
                    <p>The description of products and services are subject to change anytime without notice and it is Your responsibility to monitor the changes or verify the same before purchasing any product or services.</p>
                    <p>By using the Site and/or sharing any information, data or content with Bajaj Finance Ltd., You agree that the said information, data or content is not in violation of any applicable law or any third party intellectual property right. You understand that Bajaj Finance Ltd. may further reproduce or publish such information, content or data subject to applicable data privacy laws and confidentiality obligations.</p>
                    </div>
                    </div>
                    <div class="p_termsalltypetext" id="warranty">
                    <div class="title_termover">
                    <h2>NO REPRESENTATION OR WARRANTY</h2>
                    </div>
                    <div class="p_termsimpletext">
                    <p>No information sent to any user through this Site or available on this Site or on any third party websites listed on the Site shall constitute any representation or warranty by Bajaj Finance Ltd., or its Group Companies, Subsidiaries or Affiliates regarding the credit-worthiness, financial performance or prospects, solvency, or viability of any company or other legal entity or the business carried on by such entity.</p>
                    <p>This Site may contain statements of various professionals/ experts/ analysts, etc. Bajaj Finance Ltd., does not represent/ endorse the accuracy, reliability of any of statements/ information by any such person. It is the responsibility of the user of this Site to independently verify and evaluate the accuracy, completeness, reliability and usefulness of any statements, services or other information provided on this Site. All information in this Site is being provided under the condition and understanding that the same is not being interpreted or relied on as legal, accounting, tax, financial, investment or other professional advice, or as advice on specific facts or matters. Bajaj Finance Ltd. may at any time (without being obliged to do so) update, edit, alter and or remove any information in whole or in part that may be available on this Site and shall not be held responsible for all or any actions that may subsequently result in any loss, damage and or liability. Nothing contained herein is to be construed as any advice or recommendation to use any product or process. Though Bajaj Finance Ltd. will endeavour that information contained on this Site is obtained from sources which are reliable, however Bajaj Finance Ltd. does not warrant such information’s completeness or accuracy</p>
                    <p>Internet transactions may be subject to interruption, transmission blackout, delayed transmission and incorrect data transmission. Bajaj Finance Ltd. is not liable for malfunctions in communications facilities not under its control that may affect the accuracy or timeliness of messages and transactions the user may initiate.</p>
                    <p>Bajaj Finance Ltd. does not represent or warrant that the Site will be uninterruptedly available. Please note that the Site may not meet the user’s requirements, that access may be interrupted, that there may be delays, failures, errors or omissions or loss of transmitted information, that viruses or other contaminating or destructive properties may be transmitted or that damage may occur to your computer system. You have sole responsibility for ensuring adequate protection and back up of data and/or equipment and for undertaking reasonable and appropriate precautions to scan for computer viruses or other destructive properties. Bajaj Finance Ltd. makes no representations or warranties regarding the accuracy, functionality or performance of any third-party service or software that may be used relating to the Site.</p>
                    <p>Description of products and services are subject to change from time to time without notice. Bajaj Finance Ltd. shall not be responsible for any errors, inaccuracies or omissions with respect to any product or service displayed on the Site and Bajaj Finance Ltd. undertakes no obligation to update/amend the same.</p>
                    </div>
                    </div>
                    <div class="p_termsalltypetext" id="limitation">
                    <div class="title_termover">
                    <h2>LIMITATION OF LIABILITY</h2>
                    </div>
                    <div class="p_termsimpletext">
                    <p>Bajaj Finance Ltd., its Group Companies, Corporate Partners, subsidiary companies, its affiliates, and their directors and employees accept no liability for any loss or damage arising directly or indirectly (including special, incidental or consequential, punitive, or exemplary loss, dam age or expenses) from your use of this Site or any linked site howsoever arising, and including any loss, damage or expense arising from, but not limited to, any defect, error, omission, interruption, imperfection, fault, mistake or inaccuracy with this Site, , its contents or associated services orthe services or products mentioned on the Site or due to any unavailability of the Site or any part thereof or any contents or associated services.</p>
                    <p>Bajaj Finance Ltd. reserves the right to change the information provided on or via this Site, including the terms of this disclaimer, at any time and without notice. However, Bajaj Finance Ltd. shall not undertake to update the content contained on this Site from time to time. You are obliged to exercise your independent diligence on the information provided on or via this Site before arriving at any decision and you will be solely responsible for your actions. Bajaj Finance Ltd. shall not be held responsible for all or any actions that may subsequently result in any loss, damage and or liability on account of such change in the information on this Site.</p>
                    </div>
                    </div>
                    <div class="p_termsalltypetext" id="property">
                    <div class="title_termover">
                    <h2>INTELLECTUAL PROPERTY RIGHTS</h2>
                    </div>
                    <div class="p_termsimpletext">
                    <p>Nothing contained in our website should be construed as granting any license or right to use any Trade Marks displayed on our website. Bajaj Finance Ltd., retains all rights (including copyrights, trademarks, patents as well as any other intellectual property right) in relation to all information provided on or via this Site (including all texts, graphics and logos). Similarly, third party entities retain all intellectual property right on their products/services which are displayed on the Site, Users are prohibited from using, modifying, copying, distributing, transmitting, displaying, publishing, selling, licensing, creating derivative works or using any Content available on or through the Site for any purpose without written permission of Bajaj Finance Ltd. of such or such other parties. The materials on this website are protected by copyright and no part of such materials may be modified, reproduced, stored in a retrieval system, transmitted (in any form or by any means), copied, distributed, used for creating derivative works or used in any other way for commercial or public purposes without the prior written consent of Bajaj Finance Ltd.</p>
                    </div>
                    </div>
                    <div class="p_termsalltypetext" id="websites">
                    <div class="title_termover">
                    <h2>LINKED WEBSITES</h2>
                    </div>
                    <div class="p_termsimpletext">
                    <p>This Site may contain links to other websites of Group Companies, Corporate Partners, Subsidiary companies and Affiliate companies of Bajaj Finance Ltd. This Site may also contain links to external websites, having further linked websites, controlled or offered by third parties (Non-Affiliates of Bajaj Finance Ltd.), to help you find relevant websites, services and/or products which may be of interest to you, quickly and easily. The contents displayed or products / services offered on such linked websites or any quality of the products/ services are not endorsed, verified or monitored by Bajaj Finance Ltd. Bajaj Finance Ltd. is also not responsible for the owners or operators of such external websites or for any products or services they supply or for the contents of their websites and do not give or enter into any conditions, warranties, express or implied; or other terms or representations in relation to any of these or accept any liability in relation to any of these (including any liability arising out of any claim that the content of any external website to which this website includes a link infringes the intellectual property rights of any third party).</p>
                    </div>
                    </div>
                    <div class="p_termsalltypetext" id="governing">
                    <div class="title_termover">
                    <h2>GOVERNING LAW</h2>
                    </div>
                    <div class="p_termsimpletext">
                    <p>This Site and disclaimer shall be governed by and construed in accordance with all applicable laws of India. All disputes arising out of or relating to this disclaimer or use of this website shall be submitted to the exclusive jurisdiction of the courts of Pune.</p>
                    <p>By accessing this Web Site and any of its webpages, it is deemed that you are agreeing to the terms set out above.</p>
                    </div>
                    </div>
                    </div>
                    </section>
                    </div>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 0
            ];
            $this->blockFactory->create()->setData($termsAndConditionsBlock)->save();
            
            $disclaimerBlock = [
                'title' => 'Disclaimer',
                'identifier' => 'disclaimer',
                'content'=> '<div class="maxcontainer">
                    <section class="p_termcondition">
                    <div class="j_breaDiv">
                    <ul class="bradecrum">
                    <li><a href="javascript:void(0);">Home</a>
                    <p>&gt;</p>
                    </li>
                    <li class="active"><a href="javascript:void(0);">Disclaimer</a></li>
                    </ul>
                    </div>
                    <div class="p_termstitle">
                    <h2>DISCLAIMER</h2>
                    </div>
                    <div class="p_termconditiondeta">
                    <div class="p_termtebs">
                    <ul>
                    <li><a href="terms-and-conditions">Terms of use</a></li>
                    <li><a class="active" href="disclaimer">Disclaimer</a></li>
                    <li><a href="privacy-policy">Privacy Policy</a></li>
                    <li><a href="grievance-redressal">Grievance Redressal</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="p_termalldetatext">
                    <div class="p_termlinks" hidden>
                    <ul>
                    <li><i>1.</i> <a href="javascript:void(0);" data-tab="overview">Disclaimer</a></li>
                    </ul>
                    </div>
                    <div class="p_termsalltypetext" id="overview">
                    <div class="title_termover" hidden>
                    <h2>Disclaimer</h2>
                    </div>
                    <div class="p_termsimpletext">
                    <p>Bajaj Finance Ltd. is merely displaying the products of various dealers/manufacturers/merchants/online e-commerce marketplace/website aggregators (“Sellers�?) on its website/platform, that may be purchased by a customer (“You�?).</p>
                    <p>The said products are manufactured, sold and/or delivered by the Seller and the Seller shall be solely responsible for the quality/quantity/merchantability/delivery/installation/replacement/exchange in relation to the product and related services. Bajaj Finance Ltd. shall not be liable in any manner whatsoever for any issues in relation to the product and related services provided by the Seller.</p>
                    </div>
                    </div>
                    </div>
                    </section>
                    </div>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 0
            ];
            $this->blockFactory->create()->setData($disclaimerBlock)->save();
            
            $privacyPolicyBlock = [
                'title' => 'Privacy Policy',
                'identifier' => 'privacy-policy',
                'content'=> '<div class="maxcontainer">
                    <section class="p_termcondition">
                    <div class="j_breaDiv">
                    <ul class="bradecrum">
                    <li><a href="javascript:void(0);">Home</a>
                    <p>&gt;</p>
                    </li>
                    <li class="active"><a href="javascript:void(0);">Privacy policy</a></li>
                    </ul>
                    </div>
                    <div class="p_termstitle">
                    <h2>PRIVACY POLICY</h2>
                    </div>
                    <div class="p_termconditiondeta">
                    <div class="p_termtebs">
                    <ul>
                    <li><a href="terms-and-conditions">Terms of use</a></li>
                    <li><a href="disclaimer">Disclaimer</a></li>
                    <li><a class="active" href="privacy-policy">Privacy Policy</a></li>
                    <li><a href="grievance-redressal">Grievance Redressal</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="p_termalldetatext">
                    <div class="p_termlinks" hidden>
                    <ul>
                    <li><i>1.</i> <a href="javascript:void(0);" data-tab="overview">Collection of Information</a></li>
                    <li><i>2.</i> <a href="javascript:void(0);" data-tab="userDec">Use and disclosure of Personal &amp; Financial Information</a></li>
                    </ul>
                    </div>
                    <div class="p_termsimpletext headline">
                    <p>At BAJAJ FINANCE LTD. we are strongly committed to protect the personal and financial information that you submit to us and endeavour to protect it from unauthorized use. To protect your personal information from unauthorized access and use, we use security measures that comply with the applicable laws.</p>
                    </div>
                    <div class="p_termsalltypetext" id="overview">
                    <div class="title_termover">
                    <h3>Collection of Information</h3>
                    </div>
                    <div class="p_termsimpletext">
                    <p>While using this Site or availing the products and services, BAJAJ FINANCE LTD. and its affiliates/ subsidiaries may become privy to the personal information of its users, including information that is of a confidential &amp; sensitive nature.</p>
                    <p>BAJAJ FINANCE LTD. is strongly committed to protecting the privacy of its users and has taken all necessary and reasonable measures to protect the confidentiality of the user information and its transmission through the world wide web and it shall not be held liable for disclosure of the confidential information when in accordance with this Privacy Policy or in terms of the agreements, if any, with the Users.</p>
                    <p>In addition, like most sites, we use small bits of data called ‘cookies’ stored on user’s computers to stimulate a continuous connection. Cookies allow us storage of information about your preferences and certain session information that allow you to move to different pages of our secure site without having to re-enter your information. Any information collected is stored in secure databases protected via a variety of access controls and is treated as confidential information by us.</p>
                    <p>You should be responsible in safe custody and usage of the username and password by maintaining strict confidentiality of the same and ensure that you do not knowingly or accidentally share, provide and facilitate unauthorized use of it by any other person.</p>
                    </div>
                    </div>
                    <div class="p_termsalltypetext" id="userDec">
                    <div class="title_termover">
                    <h3>Use and disclosure of Personal &amp; Financial Information</h3>
                    </div>
                    <div class="p_termsimpletext">
                    <p>We understand clearly that You and Your Personal Information is one of our most important assets. We store and process Your Information including any sensitive financial information collected (as defined under the Information Technology Act, 2000), if any, on computers that may be protected by physical as well as reasonable technological security measures and procedures in accordance with Information Technology Act 2000 and Rules there under. If You object to Your Information being transferred or used in this way, please do not provide the details of your information on the Website.</p>
                    <p>BAJAJ FINANCE LTD. may, for the purpose of rendering its services, collect personal information such as:</p>
                    <p>1.Name, telephone/mobile number, location, email address or;</p>
                    <p>BAJAJ FINANCE LTD. offers online platform which displays various products and services of third party entities and which may be purchased by You on loan from Bajaj Finance Ltd. In further of the same, we may collects such personal data or information to display select products/services that may be of relevance to you or for serving you better. The information so collected may be shared with other group companies/ affiliates/subsidiaries/Companies/Product owner etc. solely for the purpose of processing your transaction requests or serving you better.</p>
                    <p>When you register with this Website, you agree that we or any of our affiliate/ group companies/subsidiaries may contact you from time to time to provide the offers/ information of such products/ services.</p>
                    <p>The information collected shall be used for the purpose for which it has been collected.</p>
                    <p>We will protect your personal information against unauthorized use, dissemination or publication in the same way we would protect our confidential information of similar nature. However, we may be required to disclose your personal and financial information to the statutory authorities relating to any legal process that may be initiated by such authorities in accordance with applicable laws.</p>
                    <p>We may use the personal information to improve our services to you and to keep you updated about our new products or other information that may be of interest to you. We may share information during normal business operations, such as providing services you have subscribed for, and any activity related to these services. It may become necessary for BAJAJ FINANCE LTD. to disclose your personal information to its agents and contractors during normal business operations for the above referred purpose. However, these parties would be required to use the information obtained from BAJAJ FINANCE LTD. for such purposes exclusively. BAJAJ FINANCE LTD. will endeavour to take all reasonable steps to ensure that the confidentiality of your information is maintained by imposing strict confidentiality standards on all the third parties to whom it discloses such information.</p>
                    <p>We may occasionally invite selected third parties to participate in offers we feel would be attractive to customers of BAJAJ FINANCE LTD. If you desire BAJAJ FINANCE LTD. to limit such sharing whereby you would not like to be informed of offers available you may contact us at email address to unsubscribe to such services. Otherwise, BAJAJ FINANCE LTD. will use the customer/user information to improve the visitor experience on the site and make subsequent offers to the visitor on products which may be of interest to him/her.</p>
                    <p>Your accessing this Site fully or in an incomplete manner or by enquiring/verifying any of the products/services offered by BAJAJ FINANCE LTD. and or your making a request to call back, it is deemed that you have expressly authorized BAJAJ FINANCE LTD. to call back or send you text messages or Chatbots for solicitation and procurement of various products and services of BAJAJ FINANCE LTD.. In this regard you shall not have any complaint nor complain to TRAI as to any alleged unsolicited calls by BAJAJ FINANCE LTD. to you.</p>
                    <p>We and our group companies/affiliates/subsidiaries will share/sell/transfer/license/convey some or all of your personal information with another business entity to carry out any business activity or reorganization, amalgamation, restructuring of business or for any other reason whatsoever. Once you provide your information to us, we and our affiliate may use such information to provide you various services with respect to your requests raised on the Site.</p>
                    <p>You authorise BAJAJ FINANCE LTD. to exchange, share, part with all information related to the details and transaction history of the customers/users to its banks/financial institutions/credit bureaus/agencies/regulators participation in any telecommunication or electronic clearing network as may be required by law, customary practice, credit reporting, statistical analysis and credit scoring, verification or risk management and shall not hold BAJAJ FINANCE LTD. liable for use or disclosure of this information.</p>
                    <p>Other websites that you may access via this Site may have different privacy policies and access to such websites will not be subject to this privacy policy. We recommend that you read the privacy statement of each such website to find out how they protect your personal information.</p>
                    <p>We use an SSL certificate to secure the information you share with us and its transmission. Because no data transmission is completely secure, and no system of physical or electronic security is impenetrable, we cannot guarantee the security of the information you send to us or the security of our servers, networks or databases. By using the Site and its Services, you: (a) agree to assume all risk relating to the information sent to us or collected by us when you access, visit and/or use the Site and its Services (including without limitation your personally identifiable information or other Registration Information); and (b) agree that we are not responsible for any loss of such information or any consequences that may result from any loss of such information.</p>
                    <p>Due to changes in legislation or enhancements to functionality and content on the Site, we may make changes to privacy policy (without being obliged to do so) and would reflect those changes in this privacy policy statement. Hence you are requested to go through the privacy policy statement on a regular basis.</p>
                    <p>Please note that this privacy policy does not create any contractual or other legal rights in or on behalf of any party, nor is it intended to do so.</p>
                    <p>By agreeing to avail the service offered by BAJAJ FINANCE LTD., you have agreed to the collection and use of your Sensitive Personal Data or Information by BAJAJ FINANCE LTD. You always have the right to refuse or withdraw your consent to share/dissemination of your Sensitive Personal Data or Information by contacting the customer care. However, in such an event, you would no longer avail the services of BAJAJ FINANCE LTD.</p>
                    </div>
                    </div>
                    </div>
                    </section>
                    </div>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 0
            ];
            $this->blockFactory->create()->setData($privacyPolicyBlock)->save();
            
            $grievaneRedressalBlock = [
                'title' => 'Grievance Redressal',
                'identifier' => 'grievance-redressal',
                'content'=> '<div class="maxcontainer">
                    <section class="p_termcondition">
                    <div class="j_breaDiv">
                    <ul class="bradecrum">
                    <li><a href="javascript:void(0);">Home</a>
                    <p>&gt;</p>
                    </li>
                    <li class="active"><a href="javascript:void(0);">Grievance Redressal</a></li>
                    </ul>
                    </div>
                    <div class="p_termstitle">
                    <h2>GRIEVANCE REDRESSAL</h2>
                    </div>
                    <div class="p_termconditiondeta">
                    <div class="p_termtebs">
                    <ul>
                    <li><a href="terms-and-conditions">Terms of use</a></li>
                    <li><a href="disclaimer">Disclaimer</a></li>
                    <li><a href="privacy-policy">Privacy Policy</a></li>
                    <li><a class="active" href="grievance-redressal">Grievance Redressal</a></li>
                    </ul>
                    </div>
                    </div>
                    <div class="p_termalldetatext">
                    <div class="p_termlinks" hidden>
                    <ul>
                    <li><i>1.</i> <a href="javascript:void(0);" data-tab="overview">Grievance Redressal</a></li>
                    </ul>
                    </div>
                    <div class="p_termsalltypetext" id="overview">
                    <div class="title_termover" hidden>
                    <h2>Grievance Redressal</h2>
                    </div>
                    <div class="p_termsimpletext">
                    <p>We are committed to resolving your queries/issues within ten working days. If you do not hear from us within this time, or you are not satisfied with our resolution of your query, you can write to us at grievanceredressalteam@bajajfinserv.in. The Grievance Redressal Officer investigates problems/issues raised by our customers and provides an impartial resolution. Our Grievance Redressal Officer, Mr. Satish Shimpi , is available on all working days as well as non-public holidays, between Monday to Friday from 9:30 am to 5:30 pm, on 020-71177266 (call charges as applicable).</p>
                    <p>If you do not hear from our Grievance Redressal Team within 3 working days, we urge you to write to our National Head Customer Experience at customerexperiencehead@bajajfinserv.in If your complaint/dispute is not redressed within a period of one month, you may appeal to the officer-in-charge of the Regional Office of DNBS at RBI, at the following address: Officer-in-charge, Reserve Bank of India, Regional Office, DNBS, fourth floor, opp. Mumbai Central Station, Byculla, Mumbai – 400 008</p>
                    </div>
                    </div>
                    </div>
                    </section>
                    </div>',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 0
            ];
            $this->blockFactory->create()->setData($grievaneRedressalBlock)->save();
    }
    
    /**
     * Create Static Pages
     */
    public function createStaticPages() {
        $pageNotFoundContent = '<div class="maxcontainer">
            <div class="p_pageerror">
            <div class="p_pageerror_data">
            <div class="p_pageerror_img"><img src="{{view url=images/wishlist_empty.svg}}"></div>
            <div class="p_pageerror_text">
            <h2>Oops…</h2>
            <p class="p_thepage">The page you requested for could not be found.</p>
            <p>You could try browsing through the following:</p>
            </div>
            <div class="p_pageeroorbtns">
            <ul>
            <li><a href="javascript:void(0);">Televisions</a></li>
            <li><a href="javascript:void(0);">Smartphones</a></li>
            <li><a href="javascript:void(0);">Laptops</a></li>
            <li><a href="javascript:void(0);">Refrigerators</a></li>
            </ul>
            </div>
            <div class="p_backtohome"><a href="javascript:void(0);">Back To Home</a></div>
            </div>
            </div>
            </div>';
        $pageNotFound = $this->pageFactory->create()->load('no-route','identifier');
        if ($pageNotFound->getId()) {
            $pageNotFound->setContent($pageNotFoundContent);
            $pageNotFound->save();
        }else{
            $newPageNotFound = [
                'title' => '404 Not Found',
                'identifier' => 'no-route',
                'page_layout' => '1column',
                'content' => $pageNotFoundContent,
                'is_active' => 1,
                'store_id' => [0]
            ];
            $this->pageFactory->create()->setData($newPageNotFound)->save();
        }
        
        $termsAndConditionsPage = [
            'title' => 'Terms & Conditions',
            'identifier' => 'terms-and-conditions',
            'page_layout' => '1column',
            'content' => '{{block class="Magento\Cms\Block\Block" block_id="terms-and-conditions"}}',
            'is_active' => 1,
            'store_id' => [0]
        ];
        $this->pageFactory->create()->setData($termsAndConditionsPage)->save();
        
        $disclaimerPage = [
            'title' => 'Disclaimer',
            'identifier' => 'disclaimer',
            'page_layout' => '1column',
            'content' => '{{block class="Magento\Cms\Block\Block" block_id="disclaimer"}}',
            'is_active' => 1,
            'store_id' => [0]
        ];
        $this->pageFactory->create()->setData($disclaimerPage)->save();
        
        $privacyPolicyPage = [
            'title' => 'Privacy Policy',
            'identifier' => 'privacy-policy',
            'page_layout' => '1column',
            'content' => '{{block class="Magento\Cms\Block\Block" block_id="privacy-policy"}}',
            'is_active' => 1,
            'store_id' => [0]
        ];
        $this->pageFactory->create()->setData($privacyPolicyPage)->save();
        
        $grievanceRedressalPage = [
            'title' => 'Grievance Redressal',
            'identifier' => 'grievance-redressal',
            'page_layout' => '1column',
            'content' => '{{block class="Magento\Cms\Block\Block" block_id="grievance-redressal"}}',
            'is_active' => 1,
            'store_id' => [0]
        ];
        $this->pageFactory->create()->setData($grievanceRedressalPage)->save();
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