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
namespace Cybage\CatalogProduct\Plugin\Product\ProductList;

class Toolbar
{
    const UPDATED_AT = 'updated_at';
    const EMI_STARTING_AT = 'emi_starting_at';
    const EMI_DESC = 'emi_desc';
    const EMI_ASC = 'emi_asc';
    const DESC = 'desc';
    const ASC = 'asc';

    public function aroundSetCollection(
        \Magento\Catalog\Block\Product\ProductList\Toolbar $subject,
        \Closure $proceed,
        $collection
    ) {
        $currentOrder = $subject->getCurrentOrder();
        $result = $proceed($collection);

        if ($currentOrder) {
            if ($currentOrder == self::UPDATED_AT) {
                $subject->getCollection()->setOrder(self::UPDATED_AT, self::DESC);
            }
            if ($currentOrder == self::EMI_DESC) {
                $subject->getCollection()->setOrder(self::EMI_STARTING_AT, self::DESC);
            } elseif ($currentOrder == self::EMI_ASC) {
                $subject->getCollection()->setOrder(self::EMI_STARTING_AT, self::ASC);
            }
        }

        return $result;
    }
}
