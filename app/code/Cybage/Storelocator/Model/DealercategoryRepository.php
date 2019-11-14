<?php

/**
 * BFL Storelocator
 *
 * @category   Storelocator Module
 * @package    BFL Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Model;

use Cybage\Storelocator\Api\DealercategoryRepositoryInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Cybage\Storelocator\Api\Data\DealercategoryInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Cybage\Storelocator\Model\ResourceModel\Dealercategory as ResourceDealercategory;
use Cybage\Storelocator\Api\Data\DealercategorySearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Store\Model\StoreManagerInterface;
use Cybage\Storelocator\Model\ResourceModel\Dealercategory\CollectionFactory as DealercategoryCollectionFactory;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Reflection\DataObjectProcessor;

class DealercategoryRepository implements DealercategoryRepositoryInterface
{

    protected $resource;
    protected $extensionAttributesJoinProcessor;
    protected $extensibleDataObjectConverter;
    protected $dealercategoryFactory;
    protected $dataObjectProcessor;
    private $storeManager;
    private $collectionProcessor;
    protected $dataObjectHelper;
    protected $dealercategoryCollectionFactory;
    protected $searchResultsFactory;
    protected $dataDealercategoryFactory;

    /**
     * @param ResourceDealercategory $resource
     * @param DealercategoryFactory $dealercategoryFactory
     * @param DealercategoryInterfaceFactory $dataDealercategoryFactory
     * @param DealercategoryCollectionFactory $dealercategoryCollectionFactory
     * @param DealercategorySearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceDealercategory $resource,
        DealercategoryFactory $dealercategoryFactory,
        DealercategoryInterfaceFactory $dataDealercategoryFactory,
        DealercategoryCollectionFactory $dealercategoryCollectionFactory,
        DealercategorySearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->dealercategoryFactory = $dealercategoryFactory;
        $this->dealercategoryCollectionFactory = $dealercategoryCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataDealercategoryFactory = $dataDealercategoryFactory;
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
        \Cybage\Storelocator\Api\Data\DealercategoryInterface $dealercategory
    ) {
        /* if (empty($dealercategory->getStoreId())) {
          $storeId = $this->storeManager->getStore()->getId();
          $dealercategory->setStoreId($storeId);
          } */

        $dealercategoryData = $this->extensibleDataObjectConverter->toNestedArray(
            $dealercategory,
            [],
            \Cybage\Storelocator\Api\Data\DealercategoryInterface::class
        );

        $dealercategoryModel = $this->dealercategoryFactory->create()->setData($dealercategoryData);

        try {
            $this->resource->save($dealercategoryModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the dealercategory: %1',
                $exception->getMessage()
            ));
        }
        return $dealercategoryModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($dealercategoryId)
    {
        $dealercategory = $this->dealercategoryFactory->create();
        $this->resource->load($dealercategory, $dealercategoryId);
        if (!$dealercategory->getId()) {
            throw new NoSuchEntityException(__('Dealercategory with id "%1" does not exist.', $dealercategoryId));
        }
        return $dealercategory->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->dealercategoryCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Cybage\Storelocator\Api\Data\DealercategoryInterface::class
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
        \Cybage\Storelocator\Api\Data\DealercategoryInterface $dealercategory
    ) {
        try {
            $dealercategoryModel = $this->dealercategoryFactory->create();
            $this->resource->load($dealercategoryModel, $dealercategory->getDealercategoryId());
            $this->resource->delete($dealercategoryModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Dealercategory: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($dealercategoryId)
    {
        return $this->delete($this->getById($dealercategoryId));
    }
}
