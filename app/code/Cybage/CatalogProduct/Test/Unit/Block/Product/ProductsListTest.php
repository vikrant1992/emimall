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

namespace Cybage\CatalogProduct\Test\Unit\Block\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\Pricing\Helper\Data;

/**
 * Test for Catalog Products List widget block
 * @covers \Cybage\CatalogProduct\Block\Product\ProductsList
 */
class ProductsListTest extends \PHPUnit\Framework\TestCase
{
    
    /**
     * @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $priceCurrencyMock;
    
    /**
     * @var \Magento\Catalog\Model\Product|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $productMock;
    
    protected function setUp()
    {
        $this->priceCurrencyMock = $this->createMock(\Magento\Framework\Pricing\PriceCurrencyInterface::class);
        $this->objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->productMock = $this->createPartialMock(Product::class, ['getId', 'load']);
    }
    /**
     * Test for method getProductPrice
     * 
     * @dataProvider currencyDataProvider
     */
    public function testGetProductPrice($amount, $format, $includeContainer, $result) {
        $id = 10;
        $this->productMock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($id));
        $this->assertEquals('10', $this->productMock->getId());
        
        $this->productMock->expects($this->once())
            ->method('load')
            ->with($id)
            ->will($this->returnValue('product_data'));
        $this->assertEquals('product_data', $this->productMock->load($id));
        
        $this->priceCurrencyMock->expects($this->once())
                ->method('convertAndFormat')
                ->with($amount, $includeContainer)
                ->will($this->returnValue($result));
        
        $helper = $this->getHelper(['priceCurrency' => $this->priceCurrencyMock]);
        
        $this->assertEquals($result, $helper->currency($amount, $format, $includeContainer));
    }
    
    /**
     * @return array
     */
    public function currencyDataProvider()
    {
        return [
            ['amount' => '100', 'format' => true, 'includeContainer' => true, 'result' => '100grn.'],
            ['amount' => '115', 'format' => true, 'includeContainer' => false, 'result' => '1150'],
        ];
    }
    
    /**
     * Get helper instance
     *
     * @param array $arguments
     * @return Data
     */
    private function getHelper($arguments)
    {
        return $this->objectManager->getObject(\Magento\Framework\Pricing\Helper\Data::class, $arguments);
    }
}
