<?php
namespace Mirasvit\SearchElastic\Adapter\Aggregation;

use Magento\Framework\Search\RequestInterface;
use Mirasvit\SearchElastic\Adapter\DataProvider;

class Builder
{
    /**
     * @var DynamicBucket
     */
    private $dynamicBucket;

    /**
     * @var TermBucket
     */
    private $termBucket;

    /**
     * @param DynamicBucket $dynamicBucket
     * @param TermBucket    $termBucket
     * @param DataProvider  $dataProvider
     */
    public function __construct(
        DynamicBucket $dynamicBucket,
        TermBucket $termBucket,
        DataProvider $dataProvider
    ) {
        $this->dynamicBucket = $dynamicBucket;
        $this->termBucket = $termBucket;
        $this->dataProvider = $dataProvider;
    }

    /**
     * @param RequestInterface $request
     * @param array            $response
     * @return array
     * @throws \Exception
     */
    public function extract(RequestInterface $request, array $response)
    {
        $aggregations = [];
        $buckets = $request->getAggregation();

        foreach ($buckets as $bucket) {
            if ($bucket->getType() == 'dynamicBucket') {
                $aggregations[$bucket->getName()] = $this->dynamicBucket->build(
                    $bucket,
                    $request->getDimensions(),
                    $response,
                    $this->dataProvider
                );
            } elseif ($bucket->getType() == 'termBucket') {
                $aggregations[$bucket->getName()] = $this->termBucket->build(
                    $bucket,
                    $response
                );
            } else {
                throw new \Exception("Bucket type not implemented.");
            }
        }

        return $aggregations;
    }
}
