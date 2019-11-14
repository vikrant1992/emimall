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

namespace Cybage\CatalogProduct\Test\Unit\Setup;

/**
 * @covers \Cybage\CatalogProduct\Setup\ProductSetup
 */
class ProductSetupTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Cybage\CatalogProduct\Setup\ProductSetup */
    protected $unit;

    protected function setUp()
    {
        $this->unit = (new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this))->getObject(
            \Cybage\CatalogProduct\Setup\ProductSetup::class
        );
    }
    
    public function testGetDefaultEntitiesContainAllAttributes()
    {
        $defaultEntities = $this->unit->getDefaultEntities();
        
        $this->assertEquals(
                [
                    'emi_starting_at',
                    'spec_score',
                    'zero_downpayment',
                    'no_cost_emi'
                ],
                array_keys($defaultEntities['catalog_product']['attributes'])   
            );
    }
}
