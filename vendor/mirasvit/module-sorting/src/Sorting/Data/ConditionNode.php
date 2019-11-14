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

use Magento\Framework\DataObject;

class ConditionNode extends DataObject
{
    const SORT_BY        = 'sortBy';
    const ATTRIBUTE      = 'attribute';
    const RANKING_FACTOR = 'rankingFactor';
    const DIRECTION      = 'direction';
    const WEIGHT         = 'weight';
    const LIMIT          = 'limit';

    public function loadArray(array $data)
    {
        $this->addData($data);

        return $this;
    }

    public function getSortBy()
    {
        return $this->getData(self::SORT_BY);
    }

    public function setSortBy($value)
    {
        return $this->setData(self::SORT_BY, $value);
    }

    public function getAttribute()
    {
        return $this->getData(self::ATTRIBUTE);
    }

    public function setAttribute($value)
    {
        return $this->setData(self::ATTRIBUTE, $value);
    }

    public function getRankingFactor()
    {
        return $this->getData(self::RANKING_FACTOR);
    }

    public function setRankingFactor($value)
    {
        return $this->setData(self::RANKING_FACTOR, $value);
    }

    public function getDirection()
    {
        return $this->getData(self::DIRECTION);
    }

    public function setDirection($value)
    {
        return $this->setData(self::DIRECTION, $value);
    }

    public function getWeight()
    {
        $val = (int)$this->getData(self::WEIGHT);

        return $val !== 0 ? $val : 1;
    }

    public function setWeight($value)
    {
        return $this->setData(self::WEIGHT, $value);
    }

    public function getLimit()
    {
        return $this->getData(self::LIMIT);
    }

    public function setLimit($value)
    {
        return $this->setData(self::LIMIT, $value);
    }
}