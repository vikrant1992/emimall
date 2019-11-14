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

namespace Cybage\CatalogProduct\Test\Unit\Plugin\Model;

/**
 * @covers \Cybage\CatalogProduct\Plugin\Model\Config
 */
class ConfigTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Set Up
     *
     * @return void
     */
    protected function setUp()
    {
        $this->config = new \Cybage\CatalogProduct\Plugin\Model\Config();
    }
    
    public function testAfterGetAttributeUsedForSortByArray()
    {
        $catalogConfig = $this->createMock(\Magento\Catalog\Model\Config::class);
        $options = [
            'name' => 'test',
            'position' => 1,
            'price' => 2.0,
            'microwave_type' => true,
            'launch_date_of_the_product' => null,
            'capacity_tons_ac' => 2,
            'emi_starting_at' => 100
            ];
        
        $expected = [];
        //New sorting options
        $expected['emi_asc'] = __('EMI Amount (Low to High)');
        $expected['emi_desc'] = __('EMI Amount (High to Low)');
        $expected['updated_at'] = __('Newest Arrivals');
        
        $actual = $this->config->afterGetAttributeUsedForSortByArray($catalogConfig, $options);
        self::assertEquals($expected, $actual);
    }
}
