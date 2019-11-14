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
 * @package   mirasvit/module-seo-filter
 * @version   1.0.14
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\SeoFilter\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Mirasvit\SeoFilter\Api\Data\RewriteInterface;

class Rewrite extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(RewriteInterface::TABLE_NAME, RewriteInterface::ID);
    }
}
