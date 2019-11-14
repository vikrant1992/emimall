<?php
/**
 * BFL Cybage_Generic
 *
 * @category   Cybage_Generic Module
 * @package    BFL Cybage_Generic
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\Generic\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterfaceFactory;
use Magento\Catalog\Model\CategoryFactory;

/**
 */
class CreateCategories implements DataPatchInterface, PatchRevertableInterface {

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    
    /** @var \Magento\Eav\Setup\EavSetupFactory */
    private $eavSetupFactory;
    
    /** @var  CategoryInterfaceFactory */
    private $categoryInterfaceFactory;

    /** @var  CategoryFactory */
    private $categoryFactory;
    
    /** @var  CategoryRepositoryInterface */
    private $categoryRepositoryInterface;

    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param CategoryInterfaceFactory $categoryInterfaceFactory
     * @param CategoryFactory $categoryFactory
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        CategoryInterfaceFactory $categoryInterfaceFactory,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->categoryInterfaceFactory = $categoryInterfaceFactory;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepositoryInterface = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function apply() {
        $this->moduleDataSetup->getConnection()->startSetup();
        $categories = [
            'Mobiles and Electronics' => [
                'Mobiles' => [
                    'Samsung',
                    'Apple',
                    'Oppo',
                    'Vivo',
                    'Mi',
                    'Gionee',
                    'Tecno',
                    'Google'
                ],
                'Laptops' => [
                    'HP',
                    'Dell',
                    'Lenovo',
                    'Acer',
                    'Apple'
                ],
                'Tablets' => [
                    'Samsung',
                    'Apple iPADs',
                    'Sony'
                ],
                'Printer',
                'Desktop',
                'Home Theatre & Speaker',
                'UPS'
            ],
            'TVs and Large Appliances' => [
                'Televisions' => [
                    'Mi',
                    'Vu',
                    'Samsung',
                    'LED TV',
                    'LCD TV',
                    '4K Ultra HD TV'
                ],
                'Air Conditioners'=> [
                    'Inverter AC',
                    'Split AC',
                    'Window AC',
                    'Hitachi',
                    'Bluestar',
                    'Voltas',
                    'Lloyd',
                    'LG'
                ],
                'Refrigerators' => [
                    'Single Door',
                    'Double Door',
                    'Multi Door',
                    'Godrej',
                    'Haier',
                    'LG',
                    'Hitachi',
                    'Samsung'
                ],
                'Washing Machines' => [
                    'Fully Automatic Front Load',
                    'Fully Automatic Top Load',
                    'Semi Automatic Top Load',
                    'LG',
                    'Whirlpool',
                    'Hitachi',
                    'Samsung',
                    'Godrej'
                ],
                'Air Cooler',
                'Chest Freezer',
                'Freezer'
            ],
            'Kitchen Appliances' => [
                'Water Purifier',
                'Microwave Oven',
                'Flour Mill',
                'Dishwasher',
                'Juicer',
                'Grinder'
            ],
            'Small Home Appliances' => [
                'Invertor',
                'Water Heater',
                'Stabilizer',
                'Geyser',
                'Generator'
            ]
        ];
        $this->traverseCategory($categories);
        $this->moduleDataSetup->getConnection()->endSetup();
    }
    
    /**
     * traverseCategory
     * @param type $categories
     * @param type $categoryId
     */
    public function traverseCategory($categories, $categoryId = null)
    {
        // Loops through each element. If element again is array, function is recalled. If not, result is echoed.
        foreach ($categories as $category => $subCategory) {
            if (is_array($subCategory)) {
                $parentCategoryId = $this->createCategory($category, $categoryId);
                $this->traverseCategory($subCategory, $parentCategoryId);
            } else {
                $this->createCategory($subCategory, $categoryId);
            }
        }
    }
    /**
     * Create category
     * @param string $categoryName
     * @param int $parentCategoryId
     * @return int
     */
    public function createCategory($categoryName, $parentCategoryId = null)
    {
        /** new category instance **/
        $categoryModel = $this->categoryFactory->create();
        
        $urlKey = str_replace(' ', '-', $categoryName);
        $cate = $categoryModel->getCollection()->addAttributeToFilter('url_key', $urlKey)->getFirstItem();
        if ($cate->getId()) {
            return $cate->getId();
        }
        $category = $this->categoryInterfaceFactory->create();
        $category->setName($categoryName);
        /** set root category as parent category **/
        $category->setParentId($parentCategoryId);
        $category->setIsActive(1);
        $category->setData('stores', [0]);
        $this->categoryRepositoryInterface->save($category);
        return $category->getId();
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getDependencies() {
        return [];
    }

    public function revert() {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases() {
        return [];
    }
}