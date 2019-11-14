<?php


namespace Cybage\CatalogProduct\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Cybage\CatalogProduct\Setup\ProductSetupFactory;

class InstallProductAttributes implements DataPatchInterface
{

    private $moduleDataSetup;
    private $productSetupFactory;

    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ProductSetupFactory      $productSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ProductSetupFactory $productSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->productSetupFactory = $productSetupFactory;
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
        $productSetup = $this->productSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $productSetup->installEntities();
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
