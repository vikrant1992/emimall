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

namespace Cybage\Storelocator\Test\Unit\Controller;

use Magento\Framework\App\Response\RedirectInterface;

class IndexTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        $this->objectManagerHelper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $className = \Cybage\Storelocator\Controller\Index\Index::class;
        $arguments = $this->objectManagerHelper->getConstructArguments($className);
        $this->customerSessionMock = $this->createMock(\Magento\Customer\Model\Session::class);
        $this->messageManagerMock =
            $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->redirectResultMock = $this->createMock(\Magento\Framework\Controller\Result\Redirect::class);
        $this->storeManagerMock = $this->createMock(\Magento\Store\Model\StoreManager::class);
        $this->redirect = $this->createMock(RedirectInterface::class);
        $this->index = $this->objectManagerHelper->getObject($className, $arguments);
    }
    
    public function testIsCustomerLoggedIn()
    {
        $expectedResult = true;
        $this->customerSessionMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(true);
        $this->assertEquals($expectedResult, $this->index->execute());
    }
}
