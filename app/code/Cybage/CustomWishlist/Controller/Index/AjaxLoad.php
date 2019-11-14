<?php
/**
 * BFL Cybage_CustomWishlist
 *
 * @category   Cybage_CustomWishlist Module
 * @package    BFL Cybage_CustomWishlist
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\CustomWishlist\Controller\Index;

/**
 * Review controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AjaxLoad extends \Magento\Framework\App\Action\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;
    
    /**
     * Logger
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;
    
    /**
     * Core model store manager interface
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Core form key validator
     *
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, 
       \Magento\Framework\View\LayoutFactory $layoutFactory
    ) {
        $this->storeManager = $storeManager;
        $this->coreRegistry = $coreRegistry;
        $this->logger = $logger;
        $this->formKeyValidator = $formKeyValidator;
        $this->layoutFactory = $layoutFactory;
        parent::__construct($context);
    }
    
    public function execute() {
        $block = $this->layoutFactory->create()
                    ->createBlock('Magento\Wishlist\Block\Customer\Wishlist\Items')
                    ->setTemplate('Cybage_CustomWishlist::item/list.phtml');
       return $this->getResponse()->setBody($block->toHtml());
    }
}
