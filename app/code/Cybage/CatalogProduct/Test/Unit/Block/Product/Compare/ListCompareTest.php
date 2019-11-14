<?php
/**
 * BFL CatalogProduct
 *
 * @category   CatalogProduct Module
 * @package    BFL CatalogProduct
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\CatalogProduct\Test\Unit\Block\Product\Compare;

use Cybage\CatalogProduct\Block\Product\Compare\ListCompare;

class ListCompareTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        $this->layout = $this->createPartialMock(\Magento\Framework\View\Layout::class, ['getBlock']);

        $context = $this->createPartialMock(\Magento\Catalog\Block\Product\Context::class, ['getLayout']);
        $context->expects($this->any())
            ->method('getLayout')
            ->will($this->returnValue($this->layout));
        $this->wishlistItem = $this->getMockBuilder(\Magento\Wishlist\Model\Item::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'getProduct',
                'getWishlistItemId',
                'getQty',
                'getProductId'
            ])
            ->getMock();

        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->block = $objectManager->getObject(
            \Cybage\CatalogProduct\Block\Product\Compare\ListCompare::class,
            ['context' => $context]
        );
    }
    
    public function testgetMaxCount()
    {
        $data['desktop'] = 4;
        $data['devices'] = 3;
        $this->assertEquals($data, $this->block->getMaxCount());
    }

    public function testgetWishlistParams()
    {
        
        $productId = '10';
        $this->wishlistItem->expects($this->once())
            ->method('getProductId')
            ->willReturn($productId);

        $this->assertEquals($productId, $this->wishlistItem->getProductId());
    }

    public function testgetWishlistParamsWithNullProduct()
    {
        $this->wishlistItem->expects($this->once())
            ->method('getProductId')
            ->willReturn(null);
        $this->assertNull($this->wishlistItem->getProductId());
    }
}
