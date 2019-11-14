<?php
/**
 * BFL Cybage_Productdetail
 *
 * @category   Cybage_Productdetail observer
 * @package    BFL Cybage_Productdetail
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\Productdetail\Observer;

use Magento\Framework\Event\ObserverInterface;

class ProductSaveBefore implements ObserverInterface
{
    /*
     *  execute on product save before
     *  Magento\Framework\Event\ObserverInterface
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $emiStarting=$product->getEmiStartingAt();
        $productPrice=$product->getPrice();
        if(isset($productPrice)){
            $parsedPriceValue = str_replace( ',', '', $productPrice );
            $product->setPrice($parsedPriceValue);
        } 
        if(isset($emiStarting)){
            $parsedValue = str_replace( ',', '', $emiStarting );
            $product->setEmiStartingAt($parsedValue);
        }
        return $this;
    }
}
