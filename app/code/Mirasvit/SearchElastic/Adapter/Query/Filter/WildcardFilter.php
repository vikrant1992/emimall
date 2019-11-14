<?php

namespace Mirasvit\SearchElastic\Adapter\Query\Filter;

use Magento\Framework\Search\Request\Filter\Wildcard;

class WildcardFilter
{
    /**
     * @param Wildcard $filter
     * @return array
     */
    public function build(Wildcard $filter)
    {
        $query = [];

        if ($filter->getValue()) {
            $query['wildcard'][$filter->getField()] = [
                'value' => '*' . strtolower($filter->getValue()) . '*',
            ];
        }

        return [$query];
    }
}
