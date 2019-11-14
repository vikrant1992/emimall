<?php
/**
 * BFL Cybage_PriceDecimal
 *
 * @category   Cybage_PriceDecimal
 * @package    BFL Cybage_PriceDecimal
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\PriceDecimal\Model;

trait PricePrecisionConfigTrait
{


    /**
     * @return \Cybage\PriceDecimal\Model\ConfigInterface
     */
    public function getConfig()
    {
        return $this->moduleConfig;
    }

    /**
     * @return int|mixed
     */
    public function getPricePrecision()
    {
        if ($this->getConfig()->canShowPriceDecimal()) {
            return $this->getConfig()->getPricePrecision();
        }

        return 0;
    }
}
