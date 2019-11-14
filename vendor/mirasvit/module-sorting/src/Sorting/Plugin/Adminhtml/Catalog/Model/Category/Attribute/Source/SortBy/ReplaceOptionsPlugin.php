<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-sorting
 * @version   1.0.25
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\Sorting\Plugin\Adminhtml\Catalog\Model\Category\Attribute\Source\SortBy;

use Magento\Catalog\Model\Category\Attribute\Source\Sortby;
use Mirasvit\Sorting\Model\Config\Source\CriteriaSource;

class ReplaceOptionsPlugin
{
    /**
     * @var CriteriaSource
     */
    private $criteria;

    public function __construct(CriteriaSource $criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * Add Improved Sorting criteria to default "sort by" options.
     *
     * @param Sortby $subject
     * @param array  $result
     *
     * @return array
     */
    public function afterGetAllOptions(Sortby $subject, array $result = [])
    {
        return $this->criteria->toOptionArray();
    }
}
