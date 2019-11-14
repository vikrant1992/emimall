<?php

/**
 * BFL Cybage_Storelocator
 *
 * @category   BFL Cybage_Storelocator Module
 * @package    BFL Cybage_Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Test\Unit\Helper;

use Cybage\Storelocator\Helper\Category;

class CategoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Helper
     *
     * @var Cybage\Storelocator\Helper\Category
     */
    protected $helper;

    /**
     * Scope config mock
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $scopeConfigMock;

    /**
     * Customer session mock
     *
     * @var \Magento\Customer\Model\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerSessionMock;

    /**
     * @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager
     */
    protected $objectManagerHelper;

    protected function setUp()
    {
        $this->objectManagerHelper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $className = \Cybage\Storelocator\Helper\Category::class;
        $arguments = $this->objectManagerHelper->getConstructArguments($className);
        
        /**
         * @var \Magento\Framework\App\Helper\Context $context
         */
        $context = $arguments['context'];
        $this->scopeConfigMock = $context->getScopeConfig();
        $this->customerSessionMock = $arguments['customerSession'];
        $this->assetRepository = $this->getMockBuilder(\Magento\Framework\View\Asset\Repository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->helper = $this->objectManagerHelper->getObject($className, $arguments);
    }

    public function testIsCustomerLoggedIn()
    {
        $expectedResult = true;
        $this->customerSessionMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(true);
        $this->assertEquals($expectedResult, $this->helper->isCustomerLoggedIn());
    }

    public function testIsCustomerNotLoggedIn()
    {
        $expectedResult = false;
        $this->customerSessionMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(false);
        $this->assertEquals($expectedResult, $this->helper->isCustomerLoggedIn());
    }
    
    /**
     * Tests the methods that rely on the ScopeConfigInterface object to provide their return values
     * 
     */
    public function testGetGoogleApiUrl()
    {
        $configValue = 'some_value';
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Category::API_URL_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->will($this->returnValue($configValue));

        $this->assertEquals($configValue, $this->helper->getGoogleApiUrl());
    }
    
    /**
     * Tests the methods that rely on the ScopeConfigInterface object to provide their return values
     * 
     */
    public function testGetGoogleApiKey()
    {
        $configValue = 'some_value';
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Category::API_KEY_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->will($this->returnValue($configValue));

        $this->assertEquals($configValue, $this->helper->getGoogleApiKey());
    }
    
    /**
     * Tests the methods that rely on the ScopeConfigInterface object to provide their return values
     */
    public function testGetIpInfoApiUrl()
    {
        $configValue = 'some_value';
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Category::IPINFO_API_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->will($this->returnValue($configValue));

        $this->assertEquals($configValue, $this->helper->getIpInfoApiUrl());
    }
    
    public function testGetPopulaCities() {
    $popularCities = [
            'Mumbai' => [
                'data-lat' => '19.075983',
                'data-long' => '72.877655',
                'data-city' => 'Mumbai',
                'img' => $this->assetRepository->getUrl("images/mumbai.svg")
            ],
            'Delhi' => [
                'data-lat' => '28.632430',
                'data-long' => '77.218790',
                'data-city' => 'Delhi',
                'img' => $this->assetRepository->getUrl("images/delhi.svg")
            ],
            'Hyderabad' => [
                'data-lat' => '13.245980',
                'data-long' => '77.705840',
                'data-city' => 'Hyderabad',
                'img' => $this->assetRepository->getUrl("images/hyderabad.svg")
            ],
            'Chennai' => [
                'data-lat' => '13.072090',
                'data-long' => '80.201859',
                'data-city' => 'Chennai',
                'img' => $this->assetRepository->getUrl("images/chennai.svg")
            ],
            'Bangalore' => [
                'data-lat' => '12.9716',
                'data-long' => '77.5946',
                'data-city' => 'Bangalore',
                'img' => $this->assetRepository->getUrl("images/bangalore.svg")
            ],
            'Jaipur' => [
                'data-lat' => '26.9124',
                'data-long' => '75.7873',
                'data-city' => 'Jaipur',
                'img' => $this->assetRepository->getUrl("images/group-9.svg")
            ],
            'Pune' => [
                'data-lat' => '18.516726',
                'data-long' => '73.856255',
                'data-city' => 'Pune',
                'img' => $this->assetRepository->getUrl("images/pune.svg")
            ],
            'kolkata' => [
                'data-lat' => '22.5726',
                'data-long' => '88.3639',
                'data-city' => 'kolkata',
                'img' => $this->assetRepository->getUrl("images/kolkata.svg")
            ],
        ];
    $this->assertSame($popularCities, $this->helper->getPopulaCities());
    }
    
    /**
     * Tests the methods that rely on the ScopeConfigInterface object to provide their return values
     */
    public function testGetGeoLocationApiUrl()
    {
        $configValue = 'some_value';
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Category::GEOLOC_API_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->will($this->returnValue($configValue));

        $this->assertEquals($configValue, $this->helper->getGeoLocationApiUrl());
    }
}
