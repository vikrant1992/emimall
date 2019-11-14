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



namespace Mirasvit\LayeredNavigation\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Mirasvit\LayeredNavigation\Block\Renderer\Swatch;

class DisplayInCategoriesOptions implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            [
                'value' => Swatch::CATEGORY_DISPLAY_DEFAULT,
                'label' => __('Default'),
            ],
            // [
            //     'value' => Swatch::CATEGORY_DISPLAY_LABELS,
            //     'label' => __('Labels'),
            // ],
            // [
            //     'value' => Swatch::CATEGORY_DISPLAY_DROPDOWN,
            //     'label' => __('Dropdown'),
            // ],
            [
                'value' => Swatch::CATEGORY_DISPLAY_IMAGES,
                'label' => __('Images'),
            ],
            // [
            //     'value' => Swatch::CATEGORY_DISPLAY_IMAGES_LABELS,
            //     'label' => __('Images & Labels'),
            // ],
            [
                'value' => Swatch::CATEGORY_DISPLAY_TEXT,
                'label' => __('Text Swatch'),
            ],
        ];
    }
}
