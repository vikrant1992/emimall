<?php
/**
 * BFL Cybage_CatalogProduct
 *
 * @category   Cybage_CatalogProduct
 * @package    BFL Cybage_CatalogProduct
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\CatalogProduct\Controller\Wishlist\Index;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Controller\ResultFactory;

class Add extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Wishlist\Controller\WishlistProviderInterface
     */
    protected $wishlistProvider;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * @param Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Wishlist\Controller\WishlistProviderInterface $wishlistProvider
     * @param ProductRepositoryInterface $productRepository
     * @param Validator $formKeyValidator
     */
    public function __construct(
        Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Wishlist\Controller\WishlistProviderInterface $wishlistProvider,
        ProductRepositoryInterface $productRepository,
        Validator $formKeyValidator
    ) {
        $this->_customerSession = $customerSession;
        $this->wishlistProvider = $wishlistProvider;
        $this->productRepository = $productRepository;
        $this->formKeyValidator = $formKeyValidator;
        parent::__construct($context);
    }

    /**
     * Adding new item
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $result = [];
        $session = $this->_customerSession;
        $customerId = $session->getCustomer()->getId();
        if (!$customerId) {
            $result = [
                'success' => false,
                'error_reason' => 'customer_not_found',
                'message' => __('Customer not logged in.')
            ];
            return $resultJson->setData($result);
        }
        
        $wishlist = $this->wishlistProvider->getWishlist();
        if (!$wishlist) {
            $result = [
                'success' => false,
                'error_reason' => 'page_not_found',
                'message' => __('Wishlist feature is disabled.')
            ];
            return $resultJson->setData($result);
        }

        
        $requestParams = $this->getRequest()->getParams();

        $productId = isset($requestParams['product']) ? (int)$requestParams['product'] : null;
        try {
            $product = $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            $product = null;
        }

        if (!$product || !$product->isVisibleInCatalog()) {
            $result = [
                'success' => false,
                'error_reason' => 'product_not_found',
                'message' => __('We can\'t specify a product.')
            ];
            return $resultJson->setData($result);
        }

        try {
            $buyRequest = new \Magento\Framework\DataObject($requestParams);

            $response = $wishlist->addNewItem($product, $buyRequest);
            
            if (is_string($response)) {
                $result = [
                    'success' => false,
                    'message' => __('Something went wrong.')
                ];
                return $resultJson->setData($result);
            }
            if ($wishlist->isObjectNew()) {
                $wishlist->save();
            }
            $this->_eventManager->dispatch(
                'wishlist_add_product',
                ['wishlist' => $wishlist, 'product' => $product, 'item' => $response]
            );
            
            $this->_objectManager->get(\Magento\Wishlist\Helper\Data::class)->calculate();
            $wishlistItemId = $response->getData('wishlist_item_id');
            $result = [
                'success' => true,
                'item' => $wishlistItemId,
                'message' => __('Added to Wishlist')
            ];
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $result = [
                'success' => false,
                'message' => __('We can\'t add the item to Wish List right now: %1.', $e->getMessage())
            ];
        } catch (\Exception $e) {
            $result = [
                'success' => false,
                'message' => __('We can\'t add the item to Wish List right now.')
            ];
        }
        return $resultJson->setData($result);
    }
}
