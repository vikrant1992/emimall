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

namespace Cybage\PstpIntegration\Controller\Pstp;

class Getoffer extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Cybage\PstpIntegration\Helper\Data
     */
    protected $_helper;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Cybage\PstpIntegration\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Cybage\PstpIntegration\Helper\Data $helper
    ) {
        $this->_helper = $helper;
        return parent::__construct($context);
    }

    public function execute()
    {
        // Fetch configuration data from database
        $arrInputData = array("mobileNumber"=>"", "firstName"=>"", "lastName"=>"", "otp"=>"", "requestID"=>"", "currentPageUrl"=>"", "maxBrowserWidth"=>"");

        $arrInputData["mobileNumber"] = $this->getRequest()->getParam('mobileNumber');
        $arrInputData["firstName"] = $this->getRequest()->getParam('firstName');
        $arrInputData["lastName"] = $this->getRequest()->getParam('lastName');
        $arrInputData["otp"] = $this->getRequest()->getParam('otp');
        $arrInputData["requestID"] = $this->getRequest()->getParam('requestID');
        $arrInputData["currentPageUrl"] = $this->getRequest()->getParam('currentPageUrl');
        $arrInputData["maxBrowserWidth"] = $this->getRequest()->getParam('maxBrowserWidth');

        $result = $this->_helper->getCustomerOffer($arrInputData);
        return $result;
    }
}
