<?php

namespace Mirasvit\SearchElastic\Adapter\Aggregation;

use Magento\Framework\Search\Dynamic\Algorithm\Repository as AlgorithmRepository;
use Magento\Framework\Search\Dynamic\DataProviderInterface;
use Magento\Framework\Search\Dynamic\EntityStorageFactory;
use Magento\Framework\Search\Request\BucketInterface as RequestBucketInterface;

class DynamicBucket
{
    private $algRepo;

    private $entityStorageFactory;

    public function __construct(
        AlgorithmRepository $algRepo,
        EntityStorageFactory $entityStorageFactory
    ) {
        $this->algRepo              = $algRepo;
        $this->entityStorageFactory = $entityStorageFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function build(
        RequestBucketInterface $bucket,
        array $dimensions,
        array $result,
        DataProviderInterface $provider
    ) {
        /** @var DynamicBucket $bucket */
        $method = $bucket->getName() == 'price_bucket' ? $bucket->getMethod() : 'auto';
        $alg    = $this->algRepo->get($method, ['dataProvider' => $provider]);

        $data = $alg->getItems($bucket, $dimensions, $this->getStorage($result));

        $resultData = $this->prepareData($data);

        return $resultData;
    }

    /**
     * {@inheritdoc}
     */
    private function getStorage(array $queryResult)
    {
        $ids = [];
        foreach ($queryResult['hits']['hits'] as $document) {
            $ids[] = $document['_id'];
        }

        return $this->entityStorageFactory->create($ids);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function prepareData($data)
    {
        $resultData = [];
        foreach ($data as $v) {
            $from = is_numeric($v['from']) ? $v['from'] : '*';
            $to   = is_numeric($v['to']) ? $v['to'] : '*';

            unset($v['from'], $v['to']);

            $rangeName              = "{$from}_{$to}";
            $resultData[$rangeName] = array_merge(['value' => $rangeName], $v);
        }

        return $resultData;
    }
}
