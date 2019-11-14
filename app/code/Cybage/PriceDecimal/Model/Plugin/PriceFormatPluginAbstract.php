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


namespace Cybage\PriceDecimal\Model\Plugin;

use Cybage\PriceDecimal\Model\ConfigInterface;
use Cybage\PriceDecimal\Model\PricePrecisionConfigTrait;

abstract class PriceFormatPluginAbstract
{

    use PricePrecisionConfigTrait;

    /** @var ConfigInterface  */
    protected $moduleConfig;

    /**
     * @param \Cybage\PriceDecimal\Model\ConfigInterface $moduleConfig
     */
    public function __construct(
        ConfigInterface $moduleConfig
    ) {
        $this->moduleConfig  = $moduleConfig;
    }
}
