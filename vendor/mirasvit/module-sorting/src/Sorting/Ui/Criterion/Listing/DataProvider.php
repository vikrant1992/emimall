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



namespace Mirasvit\Sorting\Ui\Criterion\Listing;

use Magento\Framework\Api\Search\SearchResultInterface;

class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{

    /**
     * {@inheritdoc}
     */
    protected function searchResultToOutput(SearchResultInterface $searchResult)
    {
        $arrItems = [];

        $arrItems['items'] = [];
        /** @var \Mirasvit\Sorting\Model\Criterion $item */
        foreach ($searchResult->getItems() as $item) {
            $itemData              = $item->getData();
            $itemData['condition'] = $item->getConditionCluster()->toHtml();

            $arrItems['items'][] = $itemData;
        }

        $arrItems['totalRecords'] = $searchResult->getTotalCount();

        return $arrItems;
    }
}
