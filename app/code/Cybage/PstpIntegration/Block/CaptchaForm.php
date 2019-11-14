<?php
/**
 * BFL PstpIntegration
 *
 * @category   PstpIntegration Module
 * @package    BFL PstpIntegration
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\PstpIntegration\Block;

class CaptchaForm extends \Magento\Framework\View\Element\Template
{
    public function getFormAction()
    {
        return $this->getUrl('pstpintegration/pstp/getotp', ['_secure' => true]);
    }
    
    public function getOfferFormAction()
    {
        return $this->getUrl('pstpintegration/pstp/getoffer', ['_secure' => true]);
    }
}
