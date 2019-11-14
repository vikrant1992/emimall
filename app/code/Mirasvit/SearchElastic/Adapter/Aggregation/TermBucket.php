<?php

namespace Mirasvit\SearchElastic\Adapter\Aggregation;

use Magento\Framework\Search\Request\BucketInterface as RequestBucketInterface;

class TermBucket
{
    /**
     * @param RequestBucketInterface $bucket
     * @param array                  $response
     *
     * @return array
     */
    public function build(
        RequestBucketInterface $bucket,
        array $response
    ) {
        $values = [];

        if (isset($response['aggregations'][$bucket->getName()]['buckets'])) {
            foreach ($response['aggregations'][$bucket->getName()]['buckets'] as $resultBucket) {
                $values[$resultBucket['key']] = [
                    'value' => $resultBucket['key'],
                    'count' => $resultBucket['doc_count'],
                ];
            }
        }

        return $values;
    }
}
