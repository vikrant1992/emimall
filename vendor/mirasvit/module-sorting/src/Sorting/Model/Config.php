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



namespace Mirasvit\Sorting\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;

class Config
{
    private $scopeConfig;

    private $request;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        RequestInterface $request
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request     = $request;
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        return $this->isExtraDebug()
            || $this->request->getParam('debug') === 'sorting';
    }

    /**
     * @return bool
     */
    public function isExtraDebug()
    {
        return $this->request->getParam('debug') === 'sorting_';
    }

    /**
     * @return bool
     */
    public function isElasticSearch()
    {
        $engine = $this->scopeConfig->getValue('catalog/search/engine');

        return $engine === 'elasticsearch6' || $engine === 'elasticsearch';
    }
}
