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



namespace Mirasvit\LayeredNavigation\Model\AttributeConfig;

use Magento\Framework\DataObject;

class OptionConfig extends DataObject
{
    const OPTION_ID           = 'option_id';
    const LABEL               = 'label';
    const IMAGE_PATH          = 'image_path';
    const IS_FULL_IMAGE_WIDTH = 'is_full_image_width';

    public function getOptionId()
    {
        return $this->getData(self::OPTION_ID);
    }

    public function setOptionId($value)
    {
        return $this->setData(self::OPTION_ID, $value);
    }

    public function getLabel()
    {
        return $this->getData(self::LABEL);
    }

    public function setLabel($value)
    {
        return $this->setData(self::LABEL, $value);
    }

    public function getImagePath()
    {
        return $this->getData(self::IMAGE_PATH);
    }

    public function setImagePath($value)
    {
        return $this->setData(self::IMAGE_PATH, $value);
    }

    public function isFullImageWidth()
    {
        return $this->getData(self::IS_FULL_IMAGE_WIDTH);
    }

    public function setIsFullImageWidth($value)
    {
        return $this->setData(self::IS_FULL_IMAGE_WIDTH, $value);
    }
}