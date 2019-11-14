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
namespace Cybage\CatalogProduct\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Cybage\CatalogProduct\Setup\AdditionalProductAttributesSetupFactory;

class UpdateProductAttributes implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface 
     */
    private $moduleDataSetup;
    
    /**
     * @var AdditionalProductAttributesSetupFactory 
     */
    private $additionalProdAttrsSetupFactory;

    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param AdditionalProductAttributesSetupFactory $additionalProdAttrsSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        AdditionalProductAttributesSetupFactory $additionalProdAttrsSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->additionalProdAttrsSetupFactory = $additionalProdAttrsSetupFactory;
    }

    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply()
    {
        /**
         * @var ProductSetup $productSetup
         */
        $productSetup = $this->additionalProdAttrsSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $productSetup->installEntities();
        
        /*Remove no_cost_emi and zero_downpayment attributes*/
        $productSetup->removeAttribute(
            'catalog_product',
            'no_cost_emi'
        );
        
        $productSetup->removeAttribute(
            'catalog_product',
            'zero_downpayment'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
        
        ];
    }
}
