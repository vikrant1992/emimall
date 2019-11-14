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
namespace Cybage\CatalogProduct\Test\Unit\Controller\Wishlist\Index;

use Magento\Framework\Controller\ResultFactory;

/**
 * @covers \Cybage\CatalogProduct\Controller\Wishlist\Index\Remove
 */
class RemoveTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Wishlist\Controller\WishlistProviderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $wishlistProvider;

    /**
     * @var \Magento\Wishlist\Model\Product\AttributeValueProvider|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $attributeValueProvider;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $formKeyValidator;
    
    /**
     * @var \Magento\Wishlist\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $helperMock;
    
    protected function setUp()
    {
        $this->context = $this->createMock(\Magento\Framework\App\Action\Context::class);
        $this->objectManager = $this->createMock(\Magento\Framework\App\ObjectManager::class);
        $this->wishlistProvider = $this->createMock(\Magento\Wishlist\Controller\WishlistProvider::class);
        $this->formKeyValidator = $this->createMock(\Magento\Framework\Data\Form\FormKey\Validator::class);
        $this->attributeValueProvider = $this->createMock(\Magento\Wishlist\Model\Product\AttributeValueProvider::class);
        $this->resultFactoryMock = $this->getMockBuilder(\Magento\Framework\Controller\ResultFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->resultJsonMock = $this->createMock(\Magento\Framework\Controller\Result\Json::class);
        
        $this->resultFactoryMock->expects($this->once())
            ->method('create')
            ->with(ResultFactory::TYPE_JSON, [])
            ->willReturn($this->resultJsonMock);
        
        $this->context->expects($this->any())
            ->method('getResultFactory')
            ->willReturn($this->resultFactoryMock);
        $this->request = $this->createMock(\Magento\Framework\App\Request\Http::class);
        $this->context
            ->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($this->request));
        $this->item = $this->createMock(\Magento\Wishlist\Model\Item::class);
        $this->context
            ->expects($this->any())
            ->method('getObjectManager')
            ->willReturn($this->objectManager);
        $this->helperMock = $this->createMock(\Magento\Wishlist\Helper\Data::class);
    }
    
    /**
     * @return \Cybage\CatalogProduct\Controller\Wishlist\Index\Remove
     */
    public function getController()
    {
        return new \Cybage\CatalogProduct\Controller\Wishlist\Index\Remove(
            $this->context,
            $this->wishlistProvider,
            $this->formKeyValidator,
            $this->attributeValueProvider
        );
    }
    
    public function testExecuteInvalidFormKey()
    {
        $result = [
                'success' => false,
                'error_reason' => 'invalid_form_key',
                'message' => __('Invalid Form Key. Please refresh the page.')
            ];
        
        $this->formKeyValidator
            ->expects($this->once())
            ->method('validate')
            ->with($this->request)
            ->will($this->returnValue(false));
        
        $this->resultJsonMock
            ->expects($this->once())
            ->method('setData')
            ->with($result)
            ->willReturnSelf();
        
        $controller = $this->getController();
        $this->assertEquals($this->resultJsonMock, $controller->execute());
    }
    
    public function testExecuteWithoutItem()
    {
        $result = [
                'success' => false,
                'error_reason' => 'item_id_not_found',
                'message' => __('Page not found.')
            ];
        $id = null;
        
        $this->formKeyValidator
            ->expects($this->once())
            ->method('validate')
            ->with($this->request)
            ->will($this->returnValue(true));
        
        $this->request->expects($this->once())
            ->method('getParam')
            ->with('item')
            ->will($this->returnValue($id));
        
        $this->item->expects($this->once())
            ->method('load')
            ->with($id)
            ->willReturnSelf();
        
        $this->objectManager
            ->expects($this->once())
            ->method('create')
            ->with(\Magento\Wishlist\Model\Item::class)
            ->willReturn($this->item);
        
        $this->item->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($id));
        
        $this->resultJsonMock
            ->expects($this->once())
            ->method('setData')
            ->with($result)
            ->willReturnSelf();
        
        $controller = $this->getController();
        $this->assertEquals($this->resultJsonMock, $controller->execute());
    }
    
    public function testExecuteWithoutWishlistItem()
    {
        $result = [
                'success' => false,
                'error_reason' => 'wishlist_not_found',
                'message' => __('Page not found.')
            ];
        $id = 1;
        $wishlistId = null;
        $this->formKeyValidator
            ->expects($this->once())
            ->method('validate')
            ->with($this->request)
            ->will($this->returnValue(true));
        
        $this->request->expects($this->once())
            ->method('getParam')
            ->with('item')
            ->will($this->returnValue($id));
        
        $this->item->expects($this->once())
            ->method('load')
            ->with($id)
            ->willReturnSelf();
        
        $this->objectManager
            ->expects($this->once())
            ->method('create')
            ->with(\Magento\Wishlist\Model\Item::class)
            ->willReturn($this->item);
        
        $this->item->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($id));
        
        $this->item->expects($this->once())
            ->method('__call')
            ->with('getWishlistId')
            ->will($this->returnValue($wishlistId));
        
        $this->wishlistProvider
            ->expects($this->once())
            ->method('getWishlist')
            ->will($this->returnValue(null));
        
        $this->resultJsonMock
            ->expects($this->once())
            ->method('setData')
            ->with($result)
            ->willReturnSelf();
        
        $controller = $this->getController();
        $this->assertEquals($this->resultJsonMock, $controller->execute());
    }
    
    public function testExecuteRemoveFromWishlistSuccess()
    {
        $result = [
                'success' => true,
                'message' => __('Removed from Wishlist')
            ];
        $id = 1;
        $wishlistId = 1;
        $this->formKeyValidator
            ->expects($this->once())
            ->method('validate')
            ->with($this->request)
            ->will($this->returnValue(true));
        
        $this->request->expects($this->once())
            ->method('getParam')
            ->with('item')
            ->will($this->returnValue($id));
        
        $this->item->expects($this->once())
            ->method('load')
            ->with($id)
            ->willReturnSelf();
        
        $this->objectManager
            ->expects($this->once())
            ->method('create')
            ->with(\Magento\Wishlist\Model\Item::class)
            ->willReturn($this->item);
        
        $this->item->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($id));
        
        $this->item->expects($this->once())
            ->method('__call')
            ->with('getWishlistId')
            ->will($this->returnValue($wishlistId));
        
        $wishlist = $this->createMock(\Magento\Wishlist\Model\Wishlist::class);
        $this->wishlistProvider
            ->expects($this->once())
            ->method('getWishlist')
            ->will($this->returnValue($wishlist));
        
        $this->item->expects($this->once())
            ->method('delete')
            ->willReturnSelf();
        
        $wishlist->expects($this->once())
            ->method('save')
            ->willReturnSelf();
        
        $this->helperMock->expects($this->once())
            ->method('calculate')
            ->willReturnSelf();
        
        $this->objectManager
            ->expects($this->once())
            ->method('get')
            ->with(\Magento\Wishlist\Helper\Data::class)
            ->willReturn($this->helperMock);
        
        $this->resultJsonMock
            ->expects($this->once())
            ->method('setData')
            ->with($result)
            ->willReturnSelf();
        
        $controller = $this->getController();
        $this->assertEquals($this->resultJsonMock, $controller->execute());
    }
}
