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

namespace Cybage\CatalogProduct\Test\Unit\Helper\Product\Compare;

use Cybage\CatalogProduct\Helper\Product\Compare\Data;
use Magento\Framework\App\Action\Action;

class DataTest extends \PHPUnit\Framework\TestCase
{

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->urlBuilder = $this->createPartialMock(\Magento\Framework\Url::class, ['getUrl']);
        $this->request = $this->createPartialMock(
            \Magento\Framework\App\Request\Http::class,
            ['getServer', 'isSecure']
        );
        /** @var \Magento\Framework\App\Helper\Context $context */
        $this->context = $this->createPartialMock(
            \Magento\Framework\App\Helper\Context::class,
            ['getUrlBuilder', 'getRequest', 'getUrlEncoder']
        );
        $this->urlEncoder = $this->getMockBuilder(\Magento\Framework\Url\EncoderInterface::class)->getMock();
        $this->urlEncoder->expects($this->any())
            ->method('encode')
            ->willReturnCallback(
                function ($url) {
                    return strtr(base64_encode($url), '+/=', '-_,');
                }
            );
        $this->context->expects($this->once())
            ->method('getUrlBuilder')
            ->will($this->returnValue($this->urlBuilder));
        $this->context->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($this->request));
        $this->context->expects($this->once())
            ->method('getUrlEncoder')
            ->will($this->returnValue($this->urlEncoder));
        $this->postDataHelper = $this->createPartialMock(
            \Magento\Framework\Data\Helper\PostHelper::class,
            ['getPostData']
        );
        $this->catalogSessionMock = $this->createPartialMock(
            \Magento\Catalog\Model\Session::class,
            ['getBeforeCompareUrl']
        );

        $this->compareHelper = $objectManager->getObject(
            \Cybage\CatalogProduct\Helper\Product\Compare\Data::class,
            [
                'context' => $this->context,
                'postHelper' => $this->postDataHelper,
                'catalogSession' => $this->catalogSessionMock
            ]
        );
    }
    
   
    public function testgetAjaxPostDataParams()
    {
        //Data
        $productId = 1;
        $addUrl = 'customcatalog/product/ajaxadd';
        $postParams = [
            'product' => $productId,
        ];

        //Verification
        $this->urlBuilder->expects($this->once())
            ->method('getUrl')
            ->with($addUrl)
            ->will($this->returnValue($addUrl));
        $this->postDataHelper->expects($this->once())
            ->method('getPostData')
            ->with($addUrl, $postParams)
            ->will($this->returnValue(true));

        /** @var \Magento\Catalog\Model\Product | \PHPUnit_Framework_MockObject_MockObject $product */
        $product = $this->createPartialMock(\Magento\Catalog\Model\Product::class, ['getId', '__wakeup']);
        $product->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($productId));

        $this->assertTrue($this->compareHelper->getAjaxPostDataParams($product));
    }
    
    public function testGetAjaxUrl()
    {
        $addUrl = 'customcatalog/product/ajaxadd';
        $this->urlBuilder->expects($this->once())
            ->method('getUrl')
            ->with($addUrl)
            ->will($this->returnValue($addUrl));
        $this->assertEquals($addUrl, $this->compareHelper->getAjaxAddUrl());
    }
}
