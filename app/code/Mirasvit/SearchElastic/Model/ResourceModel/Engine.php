<?php
namespace Mirasvit\SearchElastic\Model\ResourceModel;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\CatalogSearch\Model\ResourceModel\EngineInterface;

class Engine implements EngineInterface
{
    const ATTRIBUTE_PREFIX = 'attr_';

    /**
     * Scope identifier
     */
    const SCOPE_FIELD_NAME = 'scope';

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $catalogProductVisibility;

    /**
     * @var \Magento\Framework\Indexer\ScopeResolver\IndexScopeResolver
     */
    private $indexScopeResolver;

    /**
     * @param \Magento\Catalog\Model\Product\Visibility                   $catalogProductVisibility
     * @param \Magento\Framework\Indexer\ScopeResolver\IndexScopeResolver $indexScopeResolver
     */
    public function __construct(
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Framework\Indexer\ScopeResolver\IndexScopeResolver $indexScopeResolver
    ) {
        $this->catalogProductVisibility = $catalogProductVisibility;
        $this->indexScopeResolver = $indexScopeResolver;
    }

    /**
     * Retrieve allowed visibility values for current engine
     *
     * @return int[]
     */
    public function getAllowedVisibility()
    {
        return $this->catalogProductVisibility->getVisibleInSiteIds();
    }

    /**
     * Define if current search engine supports advanced index
     *
     * @return bool
     */
    public function allowAdvancedIndex()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function processAttributeValue($attribute, $value)
    {
        return $value;
    }

    /**
     * Prepare index array as a string glued by separator
     * Support 2 level array gluing
     *
     * @param array  $index
     * @param string $separator
     * @return string
     * @SuppressWarnings(PHPMD)
     */
    public function prepareEntityIndex($index, $separator = ' ')
    {
        return $index;
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable()
    {
        return true;
    }
}
