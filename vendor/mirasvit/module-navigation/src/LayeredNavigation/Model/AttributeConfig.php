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
 * @package   mirasvit/module-navigation
 * @version   1.0.77
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\LayeredNavigation\Model;

use Magento\Framework\Model\AbstractModel;
use Mirasvit\LayeredNavigation\Api\Data\AttributeConfigInterface;
use Mirasvit\LayeredNavigation\Model\AttributeConfig\OptionConfig;

class AttributeConfig extends AbstractModel implements AttributeConfigInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\AttributeConfig::class);
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
    public function getAttributeId()
    {
        return $this->getData(self::ATTRIBUTE_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributeId($value)
    {
        return $this->setData(self::ATTRIBUTE_ID, $value);
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
    public function getConfig()
    {
        $value = $this->getData(self::CONFIG);

        try {
            return \Zend_Json::decode($value);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig(array $value)
    {
        return $this->setData(self::CONFIG, \Zend_Json::encode($value));
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionsConfig()
    {
        $value = $this->getConfigData(self::OPTIONS_CONFIG, []);

        $options = [];
        foreach ($value as $data) {
            $options[] = new OptionConfig($data);
        }

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptionsConfig(array $value)
    {
        $options = [];
        foreach ($value as $item) {
            $options[] = $item->getData();
        }

        return $this->setConfigData(self::OPTIONS_CONFIG, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryVisibilityMode()
    {
        return $this->getConfigData(self::CATEGORY_VISIBILITY_MODE, self::CATEGORY_VISIBILITY_MODE_ALL);
    }

    /**
     * {@inheritdoc}
     */
    public function setCategoryVisibilityMode($value)
    {
        return $this->setConfigData(self::CATEGORY_VISIBILITY_MODE, $value);
    }
/**
     * {@inheritdoc}
     */
    public function getCategoryDisplayMode()
    {
        return $this->getConfigData(self::CATEGORY_DISPLAY_MODE, self::CATEGORY_DISPLAY_MODE_DEFAULT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCategoryDisplayMode($value)
    {
        return $this->setConfigData(self::CATEGORY_DISPLAY_MODE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryVisibilityIds()
    {
        return $this->getConfigData(self::CATEGORY_VISIBILITY_IDS, []);
    }

    /**
     * {@inheritdoc}
     */
    public function setCategoryVisibilityIds(array $value)
    {
        return $this->setConfigData(self::CATEGORY_VISIBILITY_IDS, $value);
    }

    private function getConfigData($key, $default = null)
    {
        $config = $this->getConfig();

        return isset($config[$key]) ? $config[$key] : $default;
    }

    private function setConfigData($key, $value)
    {
        $config       = $this->getConfig();
        $config[$key] = $value;

        return $this->setConfig($config);
    }
}