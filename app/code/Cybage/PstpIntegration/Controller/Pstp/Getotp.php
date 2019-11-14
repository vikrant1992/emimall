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

class Getotp extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Cybage\PstpIntegration\Helper\Data
     */
    protected $_helper;

    protected $_coreSession;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Cybage\PstpIntegration\Helper\Data $helper
     * @param \Magento\Framework\Session\SessionManagerInterface $coreSession
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Cybage\PstpIntegration\Helper\Data $helper,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->_helper = $helper;
        $this->_coreSession = $coreSession;
        $this->_resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $captchaEnabled = 'no';
        $skipCaptchaCheck = 'no';
        if (null !== $this->getRequest()->getParam('hiddenCaptchaEnabled')) {
            $captchaEnabled = $this->getRequest()->getParam('hiddenCaptchaEnabled');
        }

        if (null !== $this->getRequest()->getParam('hiddenSkipCaptchaCheck')) {
            $skipCaptchaCheck = $this->getRequest()->getParam('hiddenSkipCaptchaCheck');
        }

        $captchaValidateResponse = $this->validateCaptcha($captchaEnabled, $skipCaptchaCheck);

        if ($captchaValidateResponse == "invalid") {
            $invalidResult = $this->_resultJsonFactory->create();
            $invalidResult->setData(['responseStatusCode' => 200, 'apiResponseCode' => 10, 'message' => "Invalid captcha", 'requestID' => '']);
            return $invalidResult;
        } else {
            $arrInputData = array(
                                "mobileNumber" => ""
                            );

            $arrInputData["mobileNumber"] = $this->getRequest()->getParam('mobileNumber');
            $result = $this->_helper->sendOtp($arrInputData);

            return $result;
        }
    }

    /**
     * Check whether to validate captcha or not
     *
     * @param $captchaEnabled $skipCaptchaCheck
     * @return string
     */
    public function validateCaptcha($captchaEnabled = 'no', $skipCaptchaCheck = 'no')
    {
        $captchaValidateResponse = '';

        if ($captchaEnabled == "yes" && $skipCaptchaCheck == "no") {
            $captchaValidateResponse = $this->getCaptchaResponseData();
            $this->unSetCaptchaResponseData();
        }

        return $captchaValidateResponse;
    }

    /**
     * Fetch captcha response from session
     *
     * @return string
     */
    public function getCaptchaResponseData()
    {
        $this->_coreSession->start();
        return $this->_coreSession->getCaptchaResponse();
    }

    /**
     * Unset captcha response from session
     *
     */
    public function unSetCaptchaResponseData()
    {
        $this->_coreSession->start();
        return $this->_coreSession->unsCaptchaResponse();
    }
}
