<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cybage\Storelocator\Test\Unit\Block;

use Cybage\Storelocator\Block\Index\Index;
class IndexTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Scope config mock
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $scopeConfigMock;
    
    /**
     * @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager
     */
    protected $objectManagerHelper;
    
    protected $model;
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->objectManagerHelper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $className = \Cybage\Storelocator\Block\Index\Index::class;
        $arguments = $this->objectManagerHelper->getConstructArguments($className);
        /**
         * @var \Magento\Framework\App\Helper\Context $context
         */
        $context = $arguments['context'];
        $this->scopeConfigMock = $context->getScopeConfig();
        
        $this->contextMock = $this->getMockBuilder(\Magento\Framework\View\Element\Template\Context::class)
            ->disableOriginalConstructor()
            ->setMethods(['getUrlBuilder'])
            ->getMock();

        $this->urlBuilderMock = $this->getMockBuilder(\Magento\Framework\UrlInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->contextMock->expects($this->any())
            ->method('getUrlBuilder')
            ->willReturn($this->urlBuilderMock);
        
        $this->cityFactory = $this->getMockBuilder(
            \Cybage\Storelocator\Model\CityFactory::class
        )
            ->setMethods(['create', 'getCollection'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->categoryHelper = $this->getMockBuilder(\Magento\Catalog\Helper\Category::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->categoryFlatState = $this->getMockBuilder(\Magento\Catalog\Model\Indexer\Category\Flat\State::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->categoryRepository = $this->getMockBuilder(\Magento\Catalog\Model\CategoryRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->customerSession = $this->getMockBuilder(\Magento\Customer\Model\Session::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->dealerFactory = $this->createPartialMock(\Cybage\Storelocator\Model\DealerFactory::class, 
                ['create', 'addFieldToFilter', 'addFieldToSelect', 'distinct', 'getCollection', 'getData']);
        
        $this->dealergroupFactory = $this->getMockBuilder(\Cybage\Storelocator\Model\DealergroupFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->offerFactory = $this->createPartialMock(
            \Cybage\Storelocator\Model\OfferFactory::class,
            ['create', 'addFieldToFilter', 'getFirstItem', 'getData', 'getCollection']
        );
        
        $this->scopeConfig = $this->getMockBuilder(\Magento\Framework\App\Config\ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->index = new Index(
            $this->contextMock,
            $this->cityFactory,
            $this->categoryHelper,
            $this->categoryFlatState,
            $this->categoryRepository,
            $this->customerSession,
            $this->dealerFactory,
            $this->dealergroupFactory,
            $this->offerFactory,
            $this->scopeConfig
        );
    }
    
    public function testGetCustomerSessionData() {
        $result = [
            'bfl_customer_city_name'    =>  'Pune',
            'category_lob'              =>  'DPF',
            'bfl_customer_flag'         =>  'N',
            'bfl_customer_dealer_lookup'=>  '1234'
        ];
        $this->customerSession->expects($this->once())
            ->method('getData')
            ->willReturn($result);
        $this->assertEquals($result, $this->index->getCustomerSessionData());
    }
    
    /**
     * @dataProvider cityDataProvider
     */
    public function testGetCityId($city) {
        $expectedResult = [
            'dealer_id' => 6,
            'group_id' => 30545,
            'address' => 'MADATHODY COMPLEX THIRUVEGAPURA,HI LINE MALL,INDIA',
            'city_id' => 1948,
            'phone' => 7902233750,
            'bajaj_dealerid' => '411344',
            'dealer_name' => 'IMANE TRADERS AND SUPERMARKETS LLP#PATTAMBI#BPES CD#140289',
            'area' => 'PATTAMBI',
            'pincode' => '679303',
            'latitude' => '18.490595',
            'longitude' => '73.75446',
            'subcategories' => '',
            'is_active' => 1,
            'lob' => 'CD;CDD;DPF',
            'dealer_logo' => '/c/r/croma.png'
        ];
        $this->cityCollection = $this->createMock(\Cybage\Storelocator\Model\ResourceModel\City\Collection::class)->setMethods(['addFieldToFilter', 'getValuesByOption', 'getValues'])->disableOriginalConstructor();
        $mock = $this->cityCollection->getMock();
        $mock->expects($this->once())
                ->method('addFieldToFilter')
                ->will($this->returnValue($mock));

        $this->cityFactory->expects($this->atLeastOnce())->method('create')->with($city)->willReturn($expectedResult);
        $this->assertEquals($expectedResult, $this->index->getCityId($city));
    }

    /**
     * @return string
     */
    public function cityDataProvider(): string
    {
        return 'Pune';
    }
    
    /**
     * Tests the methods that rely on the ScopeConfigInterface object to provide their return values
     * 
     */
    public function testGetDefaultImage()
    {
        $configValue = null;
        $this->scopeConfigMock->expects($this->any())
            ->method('getValue')
            ->with('storelocator/dealer/default_logo')
            ->will($this->returnValue($configValue));
        $this->assertEquals($configValue, $this->index->getDefaultImage());
    }
    
    /**
     * @dataProvider dealerDataProvider
     */
    public function testGetDealerOffer($dealerId) {
        $offerMock = $this->createMock(\Cybage\Storelocator\Model\ResourceModel\Offer\Collection::class);

        $this->offerFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($offerMock);
        $offerMock
            ->expects($this->once())
            ->method('addFieldToFilter')
            ->with('dealerid', ['eq' => $dealerId])
            ->willReturnSelf();
        $offerMock
            ->expects($this->once())
            ->method('getFirstItem')
            ->willReturn('expected');

        $this->assertEquals(
            'expected',
            $this->index->getDealerOffer($dealerId)
        );
    }
        
    /**
     * @dataProvider dealerDataProvider
     */
    public function testGetDealer($dealerId) {
        $expectedResult = [
            'dealer_id' => 6,
            'group_id' => 30545,
            'address' => 'MADATHODY COMPLEX THIRUVEGAPURA,HI LINE MALL,INDIA',
            'city_id' => 1948,
            'phone' => 7902233750,
            'bajaj_dealerid' => '411344',
            'dealer_name' => 'IMANE TRADERS AND SUPERMARKETS LLP#PATTAMBI#BPES CD#140289',
            'area' => 'PATTAMBI',
            'pincode' => '679303',
            'latitude' => '18.490595',
            'longitude' => '73.75446',
            'subcategories' => '',
            'is_active' => 1,
            'lob' => 'CD;CDD;DPF',
            'dealer_logo' => '/c/r/croma.png'
        ];
        $dealerMock = $this->createMock(\Cybage\Storelocator\Model\ResourceModel\Dealer\Collection::class);

        $this->dealerFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($dealerMock);
        $dealerMock
            ->expects($this->once())
            ->method('addFieldToFilter')
            ->with('bajaj_dealerid', ['eq' => $dealerId])
            ->willReturnSelf();
        $dealerMock
            ->expects($this->once())
            ->method('getFirstItem')
            ->willReturn($expectedResult);

        $this->assertEquals(
            $expectedResult,
            $this->index->getDealer($dealerId)
        );
    }
    
    /**
     * @return int
     */
    public function dealerDataProvider(): int {
        return 6;
    }
    
    public function testGetCdCddDealers() {
        $expectedResult = [
            'dealer_id' => 6,
            'group_id' => 30545,
            'address' => 'MADATHODY COMPLEX THIRUVEGAPURA,HI LINE MALL,INDIA',
            'city_id' => 1948,
            'phone' => 7902233750,
            'bajaj_dealerid' => '411344',
            'dealer_name' => 'IMANE TRADERS AND SUPERMARKETS LLP#PATTAMBI#BPES CD#140289',
            'area' => 'PATTAMBI',
            'pincode' => '679303',
            'latitude' => '18.490595',
            'longitude' => '73.75446',
            'subcategories' => '',
            'is_active' => 1,
            'lob' => 'CD;CDD;DPF',
            'dealer_logo' => '/c/r/croma.png'
        ];
        $dealerMock = $this->createMock(\Cybage\Storelocator\Model\ResourceModel\Dealer\Collection::class);
        $cityId = 1;
        $lob = 'CDD';
        $this->dealerFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($dealerMock);
        $dealerMock
            ->expects($this->once())
            ->method('getCollection')
            ->willReturnSelf();
        $dealerMock
            ->expects($this->once())
            ->method('addFieldToFilter')
            ->with('city_id', ['eq' => $cityId])
            ->willReturnSelf();
        $dealerMock
            ->expects($this->once())
            ->method('addFieldToFilter')
            ->with('lob', ['like' => '%' . $lob . '%'])
            ->willReturnSelf();
        $dealerMock
            ->expects($this->once())
            ->method('getData')
            ->willReturn($expectedResult);

        $this->assertEquals(
            $expectedResult,
            $this->index->getCdCddDealers($cityId, $lob)
        );
    }
    
    public function testGetLcgDealers() {
        $expectedResult = [
            'dealer_id' => 6,
            'group_id' => 30545,
            'address' => 'MADATHODY COMPLEX THIRUVEGAPURA,HI LINE MALL,INDIA',
            'city_id' => 1948,
            'phone' => 7902233750,
            'bajaj_dealerid' => '411344',
            'dealer_name' => 'IMANE TRADERS AND SUPERMARKETS LLP#PATTAMBI#BPES CD#140289',
            'area' => 'PATTAMBI',
            'pincode' => '679303',
            'latitude' => '18.490595',
            'longitude' => '73.75446',
            'subcategories' => '',
            'is_active' => 1,
            'lob' => 'CD;CDD;DPF',
            'dealer_logo' => '/c/r/croma.png'
        ];
        $dealerMock = $this->createMock(\Cybage\Storelocator\Model\ResourceModel\Dealer\Collection::class);
        $cityId = 1;
        $lob = 'LCF';
        $this->dealerFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($dealerMock);
        $dealerMock
            ->expects($this->once())
            ->method('getCollection')
            ->willReturnSelf();
        $dealerMock
            ->expects($this->once())
            ->method('addFieldToFilter')
            ->with('city_id', ['eq' => $cityId])
            ->willReturnSelf();
        $dealerMock
            ->expects($this->once())
            ->method('addFieldToFilter')
            ->with('lob', ['like' => '%' . $lob . '%'])
            ->willReturnSelf();
        $dealerMock
            ->expects($this->once())
            ->method('getData')
            ->willReturn($expectedResult);

        $this->assertEquals(
            $expectedResult,
            $this->index->getLcfDealers($cityId, $lob)
        );
    }
}
