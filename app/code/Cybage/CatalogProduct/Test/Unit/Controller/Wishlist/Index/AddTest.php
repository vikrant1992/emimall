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
 * @covers \Cybage\CatalogProduct\Controller\Wishlist\Index\Add
 */
class AddTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Wishlist\Controller\WishlistProviderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $wishlistProvider;

    /**
     * @var \Magento\Customer\Model\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerSession;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $formKeyValidator;
    
    /**
     * @var \Magento\Wishlist\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $helperMock;
    
    /**
     * @var \Magento\Framework\Event\ManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $eventDispatcher;

    protected function setUp()
    {
        $this->context = $this->createMock(\Magento\Framework\App\Action\Context::class);
        $this->objectManager = $this->createMock(\Magento\Framework\App\ObjectManager::class);
        $this->wishlistProvider = $this->createMock(\Magento\Wishlist\Controller\WishlistProvider::class);
        $this->formKeyValidator = $this->createMock(\Magento\Framework\Data\Form\FormKey\Validator::class);
        $this->productRepository = $this->createMock(\Magento\Catalog\Api\ProductRepositoryInterface::class);
        $this->customerSession = $this->getMockBuilder(\Magento\Customer\Model\Session::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'getCustomer'
            ])
            ->getMock();
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
        $this->context->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($this->request));
        $this->helperMock = $this->createMock(\Magento\Wishlist\Helper\Data::class);
        $this->eventManager = $this->createMock(\Magento\Framework\Event\Manager::class);
        $this->context->expects($this->any())
            ->method('getEventManager')
            ->willReturn($this->eventManager);
        $this->context
            ->expects($this->any())
            ->method('getObjectManager')
            ->willReturn($this->objectManager);
    }
    
    /**
     * @return \Cybage\CatalogProduct\Controller\Wishlist\Index\Add
     */
    public function getController()
    {
        return new \Cybage\CatalogProduct\Controller\Wishlist\Index\Add(
            $this->context,
            $this->customerSession,
            $this->wishlistProvider,
            $this->productRepository,
            $this->formKeyValidator
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
    
    public function testExecuteWithoutCustomerLoggedIn()
    {
        $customerId = false;
        $result = [
                'success' => false,
                'error_reason' => 'customer_not_found',
                'message' => __('Customer not logged in.')
            ];
        
        $this->formKeyValidator
            ->expects($this->once())
            ->method('validate')
            ->with($this->request)
            ->will($this->returnValue(true));
        
        $customerMock = $this->getMockBuilder(\Magento\Customer\Model\Customer::class)
                ->disableOriginalConstructor()
                ->setMethods([
                    'getId'
                ])
                ->getMock();
        $customerMock->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($customerId));
        
        $this->customerSession
            ->expects($this->once())
            ->method('getCustomer')
            ->will($this->returnValue($customerMock));
        
        $this->resultJsonMock
            ->expects($this->once())
            ->method('setData')
            ->with($result)
            ->willReturnSelf();

        $controller = $this->getController();
        $this->assertEquals($this->resultJsonMock, $controller->execute());
    }
    
    public function testExecuteWithoutWishlist()
    {
        $customerId = 1;
        $result = [
                    'success' => false,
                    'error_reason' => 'invalid_form_key',
                    'message' => __('Page not found.')
                ];
                
        $this->formKeyValidator
            ->expects($this->once())
            ->method('validate')
            ->with($this->request)
            ->will($this->returnValue(true));
        
        $customerMock = $this->getMockBuilder(\Magento\Customer\Model\Customer::class)
                ->disableOriginalConstructor()
                ->setMethods([
                    'getId'
                ])
                ->getMock();
        $customerMock->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($customerId));
        
        $this->customerSession
            ->expects($this->once())
            ->method('getCustomer')
            ->will($this->returnValue($customerMock));
        
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
    
    public function testExecuteWithoutProduct() 
    {
        $customerId = 1;
        $productId = null;
        $result = [
                    'success' => false,
                    'error_reason' => 'product_not_found',
                    'message' => __('We can\'t specify a product.')
                ];
        
        $this->formKeyValidator
            ->expects($this->once())
            ->method('validate')
            ->with($this->request)
            ->will($this->returnValue(true));
        
        $customerMock = $this->getMockBuilder(\Magento\Customer\Model\Customer::class)
                ->disableOriginalConstructor()
                ->setMethods([
                    'getId'
                ])
                ->getMock();
        $customerMock->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($customerId));
        
        $this->customerSession
            ->expects($this->once())
            ->method('getCustomer')
            ->will($this->returnValue($customerMock));
        
        $wishlist = $this->createMock(\Magento\Wishlist\Model\Wishlist::class);
        $this->wishlistProvider
            ->expects($this->once())
            ->method('getWishlist')
            ->will($this->returnValue($wishlist));
        
        $this->request->expects($this->once())
            ->method('getParams')
            ->will($this->returnValue(['product' => $productId]));
        
        $this->productRepository->expects($this->once())
            ->method('getById')
            ->with($productId)
            ->will($this->returnValue(false));
        
        $this->resultJsonMock
            ->expects($this->once())
            ->method('setData')
            ->with($result)
            ->willReturnSelf();
        
        $controller = $this->getController();
        $this->assertEquals($this->resultJsonMock, $controller->execute());
    }
    
    public function testExecuteUnableToAddToWishlist() 
    {
        $customerId = 1;
        $productId = 1;
        $response = 'wishlist_failed';
        $result = [
                    'success' => false,
                    'message' => __('Something went wrong.')
                ];
        
        $this->formKeyValidator
            ->expects($this->once())
            ->method('validate')
            ->with($this->request)
            ->will($this->returnValue(true));
        
        $customerMock = $this->getMockBuilder(\Magento\Customer\Model\Customer::class)
                ->disableOriginalConstructor()
                ->setMethods([
                    'getId'
                ])
                ->getMock();
        $customerMock->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($customerId));
        
        $this->customerSession
            ->expects($this->once())
            ->method('getCustomer')
            ->will($this->returnValue($customerMock));
        
        $wishlist = $this->createMock(\Magento\Wishlist\Model\Wishlist::class);
        $this->wishlistProvider
            ->expects($this->once())
            ->method('getWishlist')
            ->will($this->returnValue($wishlist));
        
        $this->request->expects($this->once())
            ->method('getParams')
            ->will($this->returnValue(['product' => $productId]));
        
        $product = $this->createMock(\Magento\Catalog\Model\Product::class);
        $this->productRepository->expects($this->once())
            ->method('getById')
            ->with($productId)
            ->will($this->returnValue($product));
        
        $product->expects($this->once())
            ->method('isVisibleInCatalog')
            ->will($this->returnValue(true));
        
        $buyRequest = $this->getRequestParams();
        
        $wishlist->expects($this->once())
            ->method('addNewItem')
            ->with($product, $buyRequest)
            ->will($this->returnValue($response));
        
        $this->resultJsonMock
            ->expects($this->once())
            ->method('setData')
            ->with($result)
            ->willReturnSelf();
        
        $controller = $this->getController();
        $this->assertEquals($this->resultJsonMock, $controller->execute());
    }
    
    public function testExecuteAddToWishlistSuccess() 
    {
        $customerId = 1;
        $productId = 1;
        $wishlistItemId = 1;
        $result = [
                    'success' => true,
                    'item' => $wishlistItemId,
                    'message' => __('Added to Wishlist')
                ];
        
        $this->formKeyValidator
            ->expects($this->once())
            ->method('validate')
            ->with($this->request)
            ->will($this->returnValue(true));
        
        $customerMock = $this->getMockBuilder(\Magento\Customer\Model\Customer::class)
                ->disableOriginalConstructor()
                ->setMethods([
                    'getId'
                ])
                ->getMock();
        $customerMock->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($customerId));
        
        $this->customerSession
            ->expects($this->once())
            ->method('getCustomer')
            ->will($this->returnValue($customerMock));
        
        $wishlist = $this->createMock(\Magento\Wishlist\Model\Wishlist::class);
        $this->wishlistProvider
            ->expects($this->once())
            ->method('getWishlist')
            ->will($this->returnValue($wishlist));
        
        $this->request->expects($this->once())
            ->method('getParams')
            ->will($this->returnValue(['product' => $productId]));
        
        $product = $this->createMock(\Magento\Catalog\Model\Product::class);
        $this->productRepository->expects($this->once())
            ->method('getById')
            ->with($productId)
            ->will($this->returnValue($product));
        
        $product->expects($this->once())
            ->method('isVisibleInCatalog')
            ->will($this->returnValue(true));
        
        $buyRequest = $this->getRequestParams();
        
        $item = $this->createMock(\Magento\Wishlist\Model\Item::class);
        
        $wishlist->expects($this->once())
            ->method('addNewItem')
            ->with($product, $buyRequest)
            ->will($this->returnValue($item));
        
        $wishlist->expects($this->once())
            ->method('isObjectNew')
            ->will($this->returnValue('true'));
        
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
        
        $item->expects($this->once())
            ->method('getData')
            ->with('wishlist_item_id')
            ->will($this->returnValue($wishlistItemId));
        
        $this->eventManager->expects($this->once())
            ->method('dispatch')
            ->with('wishlist_add_product', ['wishlist' => $wishlist, 'product' => $product, 'item' => $item])
            ->willReturn(true);
        
        $this->resultJsonMock
            ->expects($this->once())
            ->method('setData')
            ->with($result)
            ->willReturnSelf();
        
        $controller = $this->getController();
        $this->assertEquals($this->resultJsonMock, $controller->execute());
    }
    
    /**
     * Returns request params
     *
     * @return \Magento\Framework\DataObject
     */
    private function getRequestParams()
    {
        $productId = 1;
        return new \Magento\Framework\DataObject(
            ['product' => $productId]
        );
    }
}
