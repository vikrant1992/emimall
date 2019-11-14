<?php

/**
 * BFL Attributemapping
 *
 * @category   Attributemapping Module
 * @package    BFL Attributemapping
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Attributemapping\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Cybage\Attributemapping\Api\Data\AttributesInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Cybage\Attributemapping\Api\Data\AttributesSearchResultsInterfaceFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Cybage\Attributemapping\Model\ResourceModel\Attributes as ResourceAttributes;
use Cybage\Attributemapping\Api\AttributesRepositoryInterface;
use Cybage\Attributemapping\Model\ResourceModel\Attributes\CollectionFactory as AttributesCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class AttributesRepository implements AttributesRepositoryInterface {

    protected $dataObjectProcessor;
    protected $searchResultsFactory;
    protected $dataObjectHelper;
    private $storeManager;
    private $collectionProcessor;
    protected $attributesFactory;
    protected $extensibleDataObjectConverter;
    protected $attributesCollectionFactory;
    protected $dataAttributesFactory;
    protected $extensionAttributesJoinProcessor;
    protected $resource;

    /**
     * @param ResourceAttributes $resource
     * @param AttributesFactory $attributesFactory
     * @param AttributesInterfaceFactory $dataAttributesFactory
     * @param AttributesCollectionFactory $attributesCollectionFactory
     * @param AttributesSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
    ResourceAttributes $resource, AttributesFactory $attributesFactory, AttributesInterfaceFactory $dataAttributesFactory, AttributesCollectionFactory $attributesCollectionFactory, AttributesSearchResultsInterfaceFactory $searchResultsFactory, DataObjectHelper $dataObjectHelper, DataObjectProcessor $dataObjectProcessor, StoreManagerInterface $storeManager, CollectionProcessorInterface $collectionProcessor, JoinProcessorInterface $extensionAttributesJoinProcessor, ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->attributesFactory = $attributesFactory;
        $this->attributesCollectionFactory = $attributesCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAttributesFactory = $dataAttributesFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
    \Cybage\Attributemapping\Api\Data\AttributesInterface $attributes
    ) {
        /* if (empty($attributes->getStoreId())) {
          $storeId = $this->storeManager->getStore()->getId();
          $attributes->setStoreId($storeId);
          } */

        $attributesData = $this->extensibleDataObjectConverter->toNestedArray(
                $attributes, [], \Cybage\Attributemapping\Api\Data\AttributesInterface::class
        );

        $attributesModel = $this->attributesFactory->create()->setData($attributesData);

        try {
            $this->resource->save($attributesModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                    'Could not save the attributes: %1', $exception->getMessage()
            ));
        }
        return $attributesModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($attributesId) {
        $attributes = $this->attributesFactory->create();
        $this->resource->load($attributes, $attributesId);
        if (!$attributes->getId()) {
            throw new NoSuchEntityException(__('Attributes with id "%1" does not exist.', $attributesId));
        }
        return $attributes->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
    \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->attributesCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
                $collection, \Cybage\Attributemapping\Api\Data\AttributesInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
    \Cybage\Attributemapping\Api\Data\AttributesInterface $attributes
    ) {
        try {
            $attributesModel = $this->attributesFactory->create();
            $this->resource->load($attributesModel, $attributes->getAttributesId());
            $this->resource->delete($attributesModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                    'Could not delete the Attributes: %1', $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($attributesId) {
        return $this->delete($this->getById($attributesId));
    }

}
