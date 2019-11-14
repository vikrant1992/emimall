<?php

namespace Mirasvit\SearchElastic\Index\Magento\Catalog\Product; 

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\CatalogInventory\Model\Stock;
use Mirasvit\Core\Service\CompatibilityService;
use Magento\Framework\Module\Manager;

class StockStatusHelper
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var StockResolverInterface
     */
    private $stockResolver;

    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @var GetSkusByProductIdsInterface
     */
    private $getSkusByProductIds;

    /**
     * @var int
     */
    private $stockId = Stock::DEFAULT_STOCK_ID;

    /**
     * @var string
     */
    private $sourceCodes;

    /**
     * @var bool
     */
    private $showOutOfStock;

    /**
     * @var Manager
     */
    private $moduleManager;

    /**
     * @var bool
     */
    private static $multiSourceInventorySupported = false;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param ResourceConnection $resource
     * @param Manager $moduleManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        ResourceConnection $resource,
        Manager $moduleManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->resource = $resource;
        $this->moduleManager = $moduleManager;

        if (!isset(self::$multiSourceInventorySupported)) {
            self::$multiSourceInventorySupported = CompatibilityService::is23() &&
                $this->moduleManager->isOutputEnabled('Magento_InventorySales') &&
                $this->moduleManager->isOutputEnabled('Magento_Inventory');
        }

        if (self::$multiSourceInventorySupported) {
            $this->stockResolver = CompatibilityService::getObjectManager()
                ->create(\Magento\InventorySales\Model\StockResolver::class);
            $this->getSkusByProductIds = CompatibilityService::getObjectManager()
                ->create('Magento\InventoryCatalog\Model\GetSkusByProductIds');
        }
    }

    /**
     * @param integer $scopeId
     * @return void
     */
    public function init($scopeId = null) {
        $this->showOutOfStock = $this->scopeConfig->getValue(
            'cataloginventory/options/show_out_of_stock');

        if (self::$multiSourceInventorySupported) {
            $websiteId = $this->storeManager->getStore($scopeId)->getWebsiteId();
            $websiteCode = $this->storeManager->getWebsite($websiteId)->getCode();
            
            $this->stockId = $this->stockResolver->execute(
                Magento\InventorySalesApi\Api\Data\SalesChannelInterface::TYPE_WEBSITE, $websiteCode)->getStockId();

            $this->sourceCodes = $this->getSourceCodes($this->stockId);
            $this->sourceCodes = "'" . implode("','", $this->sourceCodes) ."'";
        }
    }

    /**
     * @param integer $productId
     * @return int Product stock status
     */
    public function getProductStockStatus($productId) {
        if ($this->showOutOfStock) {
            return 1;
        }

        $connection = $this->resource->getConnection();

        $defaultStock = !self::$multiSourceInventorySupported || 
            $this->stockId == Stock::DEFAULT_STOCK_ID;

        if ($defaultStock) {
            $select = $connection->select()
                ->from($this->resource->getTableName('cataloginventory_stock_status'), ['stock_status'])
                ->where('product_id = ?', (int) $productId);
        } else {
            // multi source inventory
            $sku = $this->getSkusByProductIds->execute([$productId])[$productId];
            $table = $this->resource->getTableName('inventory_source_item');
            $select = $connection->select()
                ->from($table, ['MAX(status)'])
                ->where('sku = ? AND source_code IN (' . $this->sourceCodes . ')', $sku);
        }

        try {
            return (int) $connection->fetchOne($select);      
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getSourceCodes($stockId) {
        $connection = $this->resource->getConnection();
        $select = $connection->select()
            ->from($this->resource->getTableName('inventory_source_stock_link'),
                ['source_code'])
            ->where('stock_id = ?', $stockId);
        return array_column($connection->fetchAll($select), 'source_code');
    }

}