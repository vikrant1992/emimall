<?php

namespace Mirasvit\SearchElastic\Adapter\Query;

use Magento\Framework\Search\Request\BucketInterface;
use Magento\Framework\Search\RequestInterface;

class AggregationQuery
{
    /**
     * @param RequestInterface $request
     *
     * @return array
     */
    public function build(
        RequestInterface $request
    ) {
        $query = [];

        $buckets = $request->getAggregation();
        foreach ($buckets as $bucket) {
            $query = array_merge_recursive($query, $this->buildBucket($bucket));
        }

        return $query;
    }

    /**
     * @param BucketInterface $bucket
     *
     * @return array
     */
    protected function buildBucket(
        BucketInterface $bucket
    ) {
        $field = $bucket->getField();

        if ($bucket->getType() == BucketInterface::TYPE_TERM) {
            $result = [
                $bucket->getName() => [
                    'terms' => [
                        'field' => $field . '_raw',
                        'size'  => 500,
                    ],
                ],
            ];

            return $result;
        } elseif ($bucket->getType() == BucketInterface::TYPE_DYNAMIC) {
            return [
                $bucket->getName() => [
                    'extended_stats' => [
                        'field' => $field . '_raw',
                    ],
                ],
            ];
        }

        return [];
    }
}
