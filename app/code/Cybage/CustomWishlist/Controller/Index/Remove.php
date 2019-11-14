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

use Magento\Framework\App\Action;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Controller\ResultFactory;
use Magento\Wishlist\Controller\WishlistProviderInterface;
use Magento\Wishlist\Model\Product\AttributeValueProvider;
use Magento\Wishlist\Model\Item;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Remove extends \Magento\Wishlist\Controller\AbstractIndex
{
    /**
     * @var WishlistProviderInterface
     */
    protected $wishlistProvider;

    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * @var AttributeValueProvider
     */
    private $attributeValueProvider;

    /**
     * @param Action\Context $context
     * @param WishlistProviderInterface $wishlistProvider
     * @param Validator $formKeyValidator
     * @param AttributeValueProvider|null $attributeValueProvider
     */
    public function __construct(
        Action\Context $context,
        WishlistProviderInterface $wishlistProvider,
        Validator $formKeyValidator,
        AttributeValueProvider $attributeValueProvider = null
    ) {
        $this->wishlistProvider = $wishlistProvider;
        $this->formKeyValidator = $formKeyValidator;
        $this->attributeValueProvider = $attributeValueProvider
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(AttributeValueProvider::class);
        parent::__construct($context);
    }

    /**
     * Delete wishlist
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws NotFoundException
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $isClearAll = (int)$this->getRequest()->getParam('is_clear_all');
        if($isClearAll == 0){
            $id = (int)$this->getRequest()->getParam('item_id');
            return $this->removeItem($id,$resultRedirect);
        } else {
            $wishlistId = (int)$this->getRequest()->getParam('wishlist_id');
            $wishlist = $this->wishlistProvider->getWishlist($wishlistId);
            if (!$wishlist) {
                throw new NotFoundException(__('Page not found.'));
            }
            try {
                $wishlist->delete();
                $this->messageManager->addSuccessMessage('Your wishlist has been cleared');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError(
                    __('We can\'t clear Wish List right now because of an error: %1.', $e->getMessage())
                );
            } catch (\Exception $e) {
                $this->messageManager->addError(__('We can\'t clear Wish List right now.'));
            }
            $this->_objectManager->get(\Magento\Wishlist\Helper\Data::class)->calculate();
            $redirectUrl = $this->_redirect->getRedirectUrl($this->_url->getUrl('*/*'));
            $resultRedirect->setUrl($redirectUrl);
            return $resultRedirect;
        }
    }
    
    /**
     * @param int $id
     * @param object $resultRedirect
     * @return object
     * @throws NotFoundException
     */
    public function removeItem($id, $resultRedirect) {
        $item = $this->_objectManager->create(Item::class)->load($id);
        if (!$item->getId()) {
            throw new NotFoundException(__('Page not found.'));
        }
        $wishlist = $this->wishlistProvider->getWishlist($item->getWishlistId());
        if (!$wishlist) {
            throw new NotFoundException(__('Page not found.'));
        }
        try {
            $item->delete();
            $wishlist->save();
            $productName = $this->attributeValueProvider
                ->getRawAttributeValue($item->getProductId(), 'name');
            $this->messageManager->addComplexSuccessMessage(
                'removeWishlistItemSuccessMessage',
                [
                    'product_name' => $productName,
                ]
            );
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError(
                __('We can\'t delete the item from Wish List right now because of an error: %1.', $e->getMessage())
            );
        } catch (\Exception $e) {
            $this->messageManager->addError(__('We can\'t delete the item from the Wish List right now.'));
        }
        $this->_objectManager->get(\Magento\Wishlist\Helper\Data::class)->calculate();
        $redirectUrl = $this->_redirect->getRedirectUrl($this->_url->getUrl('*/*'));
        $resultRedirect->setUrl($redirectUrl);
        return $resultRedirect;
    }
}
