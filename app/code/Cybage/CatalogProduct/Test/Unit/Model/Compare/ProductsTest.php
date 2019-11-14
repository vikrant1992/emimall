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
namespace Cybage\CatalogProduct\Test\Unit\Model\Compare;
use Cybage\CatalogProduct\Model\Compare\Products;

class ProductsTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
          $this->collectionFactoryMock = $this
            ->getMockBuilder(\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->model = new Products(
            $this->collectionFactoryMock
        );
    }

    public function testGetSimilarProductsWithEmptyInput()
    {
        $data = [];
        $this->assertEquals($data, $this->model->getSimilarProducts($data));
    }

   /* public function testGetSimilarProductsWithInput()
    {
        $data['attribute_set_id'] = 5;
        $data['existing_products'] = [12,2,3];
        $frontendAction = $this->createMock(\Magento\Catalog\Model\Product::class);
        $productsData = [
            1 => [
                'value' => '12',
                'label' => 'megha',
            ],
            2 => [
                'value' => '13',
                'label' => 'ojas',
            ]
        ];
       //$collectionMock = $this->createMock(\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory::class);
        //$this->collectionFactory->expects($this->once())->method('create')->willReturn($collectionMock);
        
//         $this->collectionFactoryMock = $this
//            ->getMockBuilder(\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory::class)
//            ->disableOriginalConstructor()
//            ->setMethods(['create'])
//            ->getMock();
        $collection = $this->getMockBuilder(\Magento\Catalog\Model\ResourceModel\Product\Collection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->collectionFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($collection);
  
       
//        $collectionMock = $this->getMockBuilder(\Magento\Catalog\Model\ResourceModel\Product\Collection::class)
//            ->disableOriginalConstructor()
//            ->getMock();
        $collection->expects($this->once())
            ->method('addFieldToSelect')->with('name')->willReturnSelf();
        $collection->expects($this->once())
            ->method('addFieldToFilter')
            //->with('attribute_set_id', $data['attribute_set_id'])
                ->withConsecutive(
            ['attribute_set_id', $data['attribute_set_id']],
            ['entity_id', $data['existing_products']]
          );
//        ->expects($this->at(2))
//            ->method('addFieldToFilter')
//            ->with('entity_id', $data['existing_products']);
        
        $items = [
            new \Magento\Framework\DataObject([
                'entity_id' => '12',
                'name' => 'megha'
            ], ['entity_id' => '13',
                'name' => 'ojas']),
        ];
        $this->productMock = $this->createMock(\Magento\Catalog\Model\Product::class);
        $collection->expects($this->any())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator($items));
        $this->assertEquals($items, $this->model->getSimilarProducts($data));
    }*/
}
