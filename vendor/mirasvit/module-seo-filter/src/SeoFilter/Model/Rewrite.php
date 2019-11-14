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



namespace Mirasvit\SeoFilter\Model;

use Magento\Framework\Model\AbstractModel;
use Mirasvit\SeoFilter\Api\Data\RewriteInterface;

class Rewrite extends AbstractModel implements RewriteInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Rewrite::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeCode()
    {
        return $this->getData(self::ATTRIBUTE_CODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributeCode($value)
    {
        return $this->setData(self::ATTRIBUTE_CODE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption()
    {
        return $this->getData(self::OPTION);
    }

    /**
     * {@inheritdoc}
     */
    public function setOption($value)
    {
        return $this->setData(self::OPTION, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getRewrite()
    {
        return $this->getData(self::REWRITE);
    }

    /**
     * {@inheritdoc}
     */
    public function setRewrite($value)
    {
        return $this->setData(self::REWRITE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreId($value)
    {
        return $this->setData(self::STORE_ID, $value);
    }

}