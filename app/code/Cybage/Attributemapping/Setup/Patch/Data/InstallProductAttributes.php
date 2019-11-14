<?php

/**
 * BFL Attributemapping
 *
 * @category   Attributemapping Module
 * @package    BFL Attributemapping
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Attributemapping\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Cybage\Attributemapping\Setup\ProductSetupFactory;

class InstallProductAttributes implements DataPatchInterface {

    private $moduleDataSetup;
    private $productSetupFactory;

    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ProductSetupFactory $productSetupFactory
     */
    public function __construct(
    ModuleDataSetupInterface $moduleDataSetup, ProductSetupFactory $productSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->productSetupFactory = $productSetupFactory;
    }

    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply() {
        /** @var ProductSetup $productSetup */
        $productSetup = $this->productSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $productSetup->installEntities();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases() {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies() {
        return [
        ];
    }

}
