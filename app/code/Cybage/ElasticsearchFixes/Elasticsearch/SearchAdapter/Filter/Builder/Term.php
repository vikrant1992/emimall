<?php
/**
 * BFL Cybage_ElasticsearchFixes
 *
 * @category   Cybage_ElasticsearchFixes
 * @package    BFL Cybage_ElasticsearchFixes
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\ElasticsearchFixes\Elasticsearch\SearchAdapter\Filter\Builder;

use Magento\Framework\Search\Request\Filter\Term as TermFilterRequest;
use Magento\Framework\Search\Request\FilterInterface as RequestFilterInterface;
use Magento\Elasticsearch\Model\Adapter\FieldMapperInterface;

class Term extends \Magento\Elasticsearch\SearchAdapter\Filter\Builder\Term
{
    /**
     * @param RequestFilterInterface|TermFilterRequest $filter
     * @return array
     */
    public function buildFilter(RequestFilterInterface $filter)
    {
        $filterQuery = [];
        $filterValues = [];
        if ($filter->getValue()) {
            $operator = is_array($filter->getValue()) ? 'terms' : 'term';
            if(is_array($filter->getValue())){
                $filterValues =array_values($filter->getValue());
                $filterQuery []= [
                $operator => [
                    $this->fieldMapper->getFieldName($filter->getField()) => $filterValues[0],
                ],
            ];
            }else{
                 $filterQuery []= [
                $operator => [
                    $this->fieldMapper->getFieldName($filter->getField()) => $filter->getValue(),
                ],
            ];
            }
        }
       
        return $filterQuery;
    }
}
