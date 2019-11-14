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
namespace Cybage\Storelocator\Model\Category;

use Magento\Eav\Model\Config;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\EavValidationRules;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Category\FileInfo;
use Magento\Framework\App\ObjectManager;

class DataProvider extends \Magento\Catalog\Model\Category\DataProvider
{
    
    /**
     * @var categoryHelper
     */
    private $categoryHelper;
    
    /**
     * @var Filesystem
     */
    private $fileInfo;

    /**
     * Constructor
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param EavValidationRules $eavValidationRules
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\Registry $registry
     * @param Config $eavConfig
     * @param \Magento\Framework\App\RequestInterface $request
     * @param CategoryFactory $categoryFactory
     * @param \Cybage\Storelocator\Helper\Category $categoryHelper
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        EavValidationRules $eavValidationRules,
        CategoryCollectionFactory $categoryCollectionFactory,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Registry $registry,
        Config $eavConfig,
        \Magento\Framework\App\RequestInterface $request,
        CategoryFactory $categoryFactory,
        \Cybage\Storelocator\Helper\Category $categoryHelper,
        array $meta = [],
        array $data = []
    ) {
        $this->categoryHelper = $categoryHelper;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $eavValidationRules,
            $categoryCollectionFactory,
            $storeManager,
            $registry,
            $eavConfig,
            $request,
            $categoryFactory,
            $meta,
            $data
        );
    }
    
	/**
     * Function to get category data
     * @return array
     */
    public function getData()
    {
        $data = parent::getData();
        $category = $this->getCurrentCategory();
        if (isset($data[$category->getId()]['category_icon'])) {
            unset($data[$category->getId()]['category_icon']);
            $fileName = $category->getData('category_icon');
            $stat = $this->getFileInfo()->getStat($fileName);
            $mime = $this->getFileInfo()->getMimeType($fileName);
            $data[$category->getId()]['category_icon'][0]['name'] = $category->getData('category_icon');
            $data[$category->getId()]['category_icon'][0]['url']  = $this->categoryHelper->getCategoryIconUrl($category);
            $data[$category->getId()]['category_icon'][0]['size'] = isset($stat) ? $stat['size'] : 0;
            $data[$category->getId()]['category_icon'][0]['type'] = $mime;
        }
        return $data;
    }
    
	/**
     * Function to get fields map
     * @return array
     */
    protected function getFieldsMap()
    {
        $fields = parent::getFieldsMap();
        return $fields;
    }
    
    /**
     * Get FileInfo instance
     *
     * @return FileInfo
     *
     * @deprecated 101.1.0
     */
    private function getFileInfo()
    {
        if ($this->fileInfo === null) {
            $this->fileInfo = ObjectManager::getInstance()->get(FileInfo::class);
        }
        return $this->fileInfo;
    }
}
