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

class ConditionFrame
{
    /**
     * @var ConditionNode[];
     */
    private $nodes = [];

    /**
     * @param array $data
     *
     * @return $this
     */
    public function loadArray(array $data)
    {
        foreach ($data as $nodeData) {
            $node = new ConditionNode();
            $node->loadArray($nodeData);

            $this->addNode($node);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];

        foreach ($this->getNodes() as $node) {
            $data[] = $node->toArray();
        }

        return $data;
    }

    /**
     * @return ConditionNode[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    public function addNode(ConditionNode $node)
    {
        $this->nodes[] = $node;

        return $this;
    }
}