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

class LinksLimitWayDisplayOptions implements ArrayInterface
{
    const OPTION_LINK_SHOW_HIDE = 0;
    const OPTION_SCROLL         = 1;
    const SCROLL_CLASS          = 'm__scroll_field';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            ['value' => self::OPTION_LINK_SHOW_HIDE, 'label' => __('Show/hide link')],
            ['value' => self::OPTION_SCROLL, 'label' => __('Scroll box')],
        ];

        return $options;
    }

}
