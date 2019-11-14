<?php
namespace Mirasvit\SearchElastic\Adapter\Query\Filter;

use Magento\Framework\Search\Request\Filter\Range;

class RangeFilter
{
    /**
     * @param Range $filter
     * @return array
     */
    public function build(Range $filter)
    {
        $query = [];

        if ($filter->getFrom()) {
            $query['range'][$filter->getField() . '_raw']['gte'] = floatval($filter->getFrom());
        }

        if ($filter->getTo()) {
            $query['range'][$filter->getField() . '_raw']['lte'] = floatval($filter->getTo());
        }

        return [$query];
    }
}
