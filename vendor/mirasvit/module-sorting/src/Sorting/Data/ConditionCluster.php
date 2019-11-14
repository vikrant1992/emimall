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



namespace Mirasvit\Sorting\Data;

use Magento\Framework\App\ObjectManager;
use Mirasvit\Sorting\Api\Data\CriterionInterface;
use Mirasvit\Sorting\Model\Config\Source\SortByAttributeSource;
use Mirasvit\Sorting\Model\Config\Source\SortByRankingFactorSource;

/**
 * ConditionCluster
 *  - ConditionFrame
 *      - ConditionNode
 *      - ConditionNode
 *      - ConditionNode
 *  - ConditionFrame
 *      - ConditionNode
 */
class ConditionCluster
{
    /**
     * @var ConditionFrame[]
     */
    private $frames = [];

    /**
     * @param array $data
     *
     * @return $this
     */
    public function loadArray(array $data)
    {
        foreach ($data as $frameData) {
            $frame = new ConditionFrame();
            $frame->loadArray($frameData);

            $this->addFrame($frame);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];

        foreach ($this->getFrames() as $frame) {
            $data[] = $frame->toArray();
        }

        return $data;
    }

    /**
     * @return ConditionFrame[]
     */
    public function getFrames()
    {
        return $this->frames;
    }

    public function addFrame(ConditionFrame $frame)
    {
        $this->frames[] = $frame;

        return $this;
    }

    public function toHtml()
    {
        $ob = ObjectManager::getInstance();

        /** @var SortByAttributeSource $attributeSource */
        $attributeSource = $ob->create(SortByAttributeSource::class);

        /** @var SortByRankingFactorSource $factorSource */
        $factorSource = $ob->create(SortByRankingFactorSource::class);

        $lines = [];
        foreach ($this->getFrames() as $fIdx => $frame) {
            foreach ($frame->getNodes() as $idx => $node) {
                if ($node->getSortBy() === CriterionInterface::CONDITION_SORT_BY_ATTRIBUTE) {
                    $label = $node->getAttribute();
                    foreach ($attributeSource->toOptionArray() as $option) {
                        if ($option['value'] == $node->getAttribute()) {
                            $label = $option['label'];
                        }
                    }

                } else {
                    $label = $node->getRankingFactor();
                    foreach ($factorSource->toOptionArray() as $option) {
                        if ($option['value'] == $node->getRankingFactor()) {
                            $label = $option['label'];
                        }
                    }
                }

                $lines[] = __(
                    '%1%2Sort by <b>%3</b> <small>%4</small>',
                    str_repeat('&nbsp', $idx * 3),
                    $fIdx === 0 ? '' : 'Then ',
                    $label,
                    $node->getDirection() === 'desc' ? 'Z-A 9-0' : 'A-Z 0-9'
                );
            }
        }

        return '<div class="mst-sorting-criterion-listing__cluster-html">' . implode('<br>', $lines) . '</div>';
    }
}