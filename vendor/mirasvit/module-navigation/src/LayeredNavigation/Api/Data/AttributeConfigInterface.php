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



namespace Mirasvit\LayeredNavigation\Api\Data;

use Mirasvit\LayeredNavigation\Model\AttributeConfig\OptionConfig;

interface AttributeConfigInterface
{
    const TABLE_NAME = 'mst_navigation_attribute_config';

    const CATEGORY_VISIBILITY_MODE_ALL              = 'all';
    const CATEGORY_VISIBILITY_MODE_SHOW_IN_SELECTED = 'show_in_selected';
    const CATEGORY_VISIBILITY_MODE_HIDE_IN_SELECTED = 'hide_in_selected';


    const ID             = 'config_id';
    const ATTRIBUTE_ID   = 'attribute_id';
    const ATTRIBUTE_CODE = 'attribute_code';
    const CONFIG         = 'config';

    const OPTIONS_CONFIG = 'options';

    const CATEGORY_VISIBILITY_MODE = 'category_visibility_mode';
    const CATEGORY_VISIBILITY_IDS  = 'category_visibility_ids';
    const CATEGORY_DISPLAY_MODE = 'category_display_mode';
    const CATEGORY_DISPLAY_MODE_DEFAULT = 'default';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getAttributeId();

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setAttributeId($value);

    /**
     * @return string
     */
    public function getAttributeCode();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAttributeCode($value);

    /**
     * @return array
     */
    public function getConfig();

    /**
     * @param array $value
     *
     * @return $this
     */
    public function setConfig(array $value);

    /**
     * @return OptionConfig[]
     */
    public function getOptionsConfig();

    /**
     * @param OptionConfig[] $value
     *
     * @return $this
     */
    public function setOptionsConfig(array $value);

    /**
     * @return string
     */
    public function getCategoryVisibilityMode();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setCategoryVisibilityMode($value);

    /**
     * @return array
     */
    public function getCategoryVisibilityIds();

    /**
     * @param array $value
     *
     * @return $this
     */
    public function setCategoryVisibilityIds(array $value);

}