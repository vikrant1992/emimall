<?php
/**
 * BFL Cybage_SeoSchema
 *
 * @category   Cybage_SeoSchema Helper
 * @package    BFL Cybage_SeoSchema
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\SeoSchema\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;

        parent::__construct($context);
    }

    /**
     * Return value for config path
     *
     * @param $configPath
     * @return string config value
     */
    public function getConfigValue($configPath = '')
    {
        return $this->_scopeConfig->getValue($configPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
    }

    /**
     * Create structure data script
     *
     * @param $data
     * @return string
     */
    public function createStructuredData($data)
    {
        $applicationLdJson = '<script type="application/ld+json">'.json_encode($data, JSON_PRETTY_PRINT).'</script>';
        return $applicationLdJson;
    }
}
