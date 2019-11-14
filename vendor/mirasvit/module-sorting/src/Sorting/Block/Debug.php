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



namespace Mirasvit\Sorting\Block;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\Template;

class Debug extends Template
{
    protected      $_template       = 'Mirasvit_Sorting::debug.phtml';

    private static $isStylesApplied = false;

    public function __construct(
        Context $context,
        array $values,
        $globalScore,
        $criterionScore
    ) {
        parent::__construct($context, [
            'values'         => $values,
            'globalScore'    => $globalScore,
            'criterionScore' => $criterionScore,
        ]);
    }

    /**
     * @return bool
     */
    public function isApplyStyles()
    {
        return !self::$isStylesApplied;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->getData('values');
    }

    /**
     * @return int
     */
    public function getGlobalScore()
    {
        return intval($this->getData('globalScore'));
    }

    /**
     * @return int
     */
    public function getCriterionScore()
    {
        return intval($this->getData('criterionScore'));
    }

    /**
     * {@inheritdoc}
     */
    protected function _toHtml()
    {
        $html = parent::_toHtml();

        self::$isStylesApplied = true;

        return $html;
    }
}
