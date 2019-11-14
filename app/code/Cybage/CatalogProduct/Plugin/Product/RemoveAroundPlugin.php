<?php
/**
 * BFL Cybage_CatalogProduct
 *
 * @category   Cybage_CatalogProduct Module
 * @package    BFL Cybage_CatalogProduct
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\CatalogProduct\Plugin\Product;

use Magento\Catalog\Controller\Product\Compare\Remove as RemoveController;
use Magento\Catalog\Helper\Product\Compare as CompareHelper;
use Magento\Customer\Model\Session;

class RemoveAroundPlugin {
    
    /**
     *
     * @var CompareHelper
     */
    protected $compareHelper;
    
    /**
     *
     * @var Session
     */
    protected $customerSession;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param CompareHelper $compareHelper
     * @param Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        CompareHelper $compareHelper,
        Session $customerSession
    ) {
        $this->_request = $context->getRequest();
        $this->_response = $context->getResponse();
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->resultFactory = $context->getResultFactory();
        $this->compareHelper = $compareHelper;
        $this->customerSession = $customerSession;
    }
    
    public function aroundExecute(RemoveController $subject, callable $proceed)
    {
        $isAjax = false;
        $isAjax = $this->_request->getParam('isAjax');
        $returnValue = $proceed();
        $itemsCount = $this->compareHelper->getItemCount();
        if ($isAjax == false && $itemsCount == 0) {
            $referrerUrl = $this->customerSession->getCompareReferrerUrl();
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setUrl($referrerUrl);
            return $resultRedirect;
        }
        return $returnValue;
    }
}
