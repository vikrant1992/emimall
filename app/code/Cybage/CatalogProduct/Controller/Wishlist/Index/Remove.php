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

use Magento\Framework\App\Action;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Controller\ResultFactory;
use Magento\Wishlist\Controller\WishlistProviderInterface;
use Magento\Wishlist\Model\Item;
use Magento\Wishlist\Model\Product\AttributeValueProvider;

class Remove extends \Magento\Framework\App\Action\Action
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
     * Remove item
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws NotFoundException
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $result = [];
        $id = (int)$this->getRequest()->getParam('item');
        /** @var Item $item */
        $item = $this->_objectManager->create(Item::class)->load($id);
        if (!$item->getId()) {
            $result = [
                'success' => false,
                'error_reason' => 'item_id_not_found',
                'message' => __('Page not found.')
            ];
            return $resultJson->setData($result);
        }
        $wishlist = $this->wishlistProvider->getWishlist($item->getWishlistId());
        if (!$wishlist) {
            $result = [
                'success' => false,
                'error_reason' => 'wishlist_not_found',
                'message' => __('Page not found.')
            ];
            return $resultJson->setData($result);
        }
        try {
            $item->delete();
            $wishlist->save();
            
            $result = [
                'success' => true,
                'message' => __('Removed from Wishlist')
            ];
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $result = [
                'success' => false,
                'error_reason' => 'wishlist_not_found',
                'message' => __('We can\'t delete the item from Wish List right now because of an error: %1.', $e->getMessage())
            ];
        } catch (\Exception $e) {
            $result = [
                'success' => false,
                'message' => __('We can\'t delete the item from the Wish List right now.')
            ];
        }

        $this->_objectManager->get(\Magento\Wishlist\Helper\Data::class)->calculate();
        return $resultJson->setData($result);
    }
}
