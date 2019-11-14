<?php
namespace Mirasvit\SearchElastic\Index;

use Mirasvit\Search\Api\Data\Index\DataMapperInterface;
use Mirasvit\Search\Api\Repository\IndexRepositoryInterface;

class DataMapper implements DataMapperInterface
{
    /**
     * @var IndexRepositoryInterface
     */
    private $indexRepository;

    public function __construct(
        IndexRepositoryInterface $indexRepository
    ) {
        $this->indexRepository = $indexRepository;
    }

    /**
     * @param array                                         $documents
     * @param \Magento\Framework\Search\Request\Dimension[] $dimensions
     * @param string                                        $indexIdentifier
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function map(array $documents, $dimensions, $indexIdentifier)
    {
        $instance = $this->indexRepository->getInstance($indexIdentifier);

        foreach ($documents as $id => $doc) {
            $map = [
                'id'                       => $id,
                $instance->getPrimaryKey() => $id,
            ];
            foreach ($doc as $attribute => $value) {
                if (is_int($attribute)) {
                    $attribute = $instance->getAttributeCode($attribute);
                }
                if (isset($map[$attribute])) {
                    $map[$attribute] .= ' ' . $value;
                } else {
                    $map[$attribute] = $value;
                }
            }

            $documents[$id] = $map;
        }

        return $documents;
    }
}
