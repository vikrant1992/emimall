<?php

namespace Mirasvit\SearchElastic\Adapter\Query\Filter;

use Magento\Framework\Search\Request\Filter\Term;

class TermFilter
{
    /**
     * @param Term $filter
     *
     * @return array
     */
    public function build(Term $filter)
    {
        $query = [];
        if ($filter->getValue()) {
            $value = $filter->getValue();

            if (is_string($value)) {
                $value = array_filter(explode(',', $value));

                if (count($value) === 1) {
                    $value = $value[0];
                }
                $value = preg_replace('/[^A-Za-z0-9 -]/', '', $value);
            }

            $condition = is_array($value) ? 'terms' : 'term';

            if (is_array($value)) {
                if (key_exists('in', $value)) {
                    $value = $value['in'];
                }

                if (key_exists('finset', $value)) {
                    $value = $value['finset'];
                }

                $value = array_values($value);
            }

            $field = $filter->getField() . '_raw';

            if ($field == 'entity_id_raw') {
                $field = 'entity_id';
            }

            $query[] = [
                $condition => [
                    $field => $value,
                ],
            ];
        }

        return $query;
    }
}
