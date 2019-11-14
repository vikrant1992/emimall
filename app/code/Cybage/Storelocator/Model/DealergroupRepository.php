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

use Cybage\Storelocator\Api\DealergroupRepositoryInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\DataObjectHelper;
use Cybage\Storelocator\Model\ResourceModel\Dealergroup\CollectionFactory as DealergroupCollectionFactory;
use Cybage\Storelocator\Api\Data\DealergroupSearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Cybage\Storelocator\Model\ResourceModel\Dealergroup as ResourceDealergroup;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Cybage\Storelocator\Api\Data\DealergroupInterfaceFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class DealergroupRepository implements DealergroupRepositoryInterface
{

    protected $resource;
    protected $extensionAttributesJoinProcessor;
    protected $extensibleDataObjectConverter;
    protected $dealergroupCollectionFactory;
    protected $dealergroupFactory;
    protected $dataObjectProcessor;
    private $storeManager;
    protected $dataDealergroupFactory;
    private $collectionProcessor;
    protected $dataObjectHelper;
    protected $searchResultsFactory;

    /**
     * @param ResourceDealergroup $resource
     * @param DealergroupFactory $dealergroupFactory
     * @param DealergroupInterfaceFactory $dataDealergroupFactory
     * @param DealergroupCollectionFactory $dealergroupCollectionFactory
     * @param DealergroupSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceDealergroup $resource,
        DealergroupFactory $dealergroupFactory,
        DealergroupInterfaceFactory $dataDealergroupFactory,
        DealergroupCollectionFactory $dealergroupCollectionFactory,
        DealergroupSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->dealergroupFactory = $dealergroupFactory;
        $this->dealergroupCollectionFactory = $dealergroupCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataDealergroupFactory = $dataDealergroupFactory;
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
        \Cybage\Storelocator\Api\Data\DealergroupInterface $dealergroup
    ) {
        /* if (empty($dealergroup->getStoreId())) {
          $storeId = $this->storeManager->getStore()->getId();
          $dealergroup->setStoreId($storeId);
          } */

        $dealergroupData = $this->extensibleDataObjectConverter->toNestedArray(
            $dealergroup,
            [],
            \Cybage\Storelocator\Api\Data\DealergroupInterface::class
        );

        $dealergroupModel = $this->dealergroupFactory->create()->setData($dealergroupData);

        try {
            $this->resource->save($dealergroupModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the dealergroup: %1',
                $exception->getMessage()
            ));
        }
        return $dealergroupModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($dealergroupId)
    {
        $dealergroup = $this->dealergroupFactory->create();
        $this->resource->load($dealergroup, $dealergroupId);
        if (!$dealergroup->getId()) {
            throw new NoSuchEntityException(__('Dealergroup with id "%1" does not exist.', $dealergroupId));
        }
        return $dealergroup->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->dealergroupCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Cybage\Storelocator\Api\Data\DealergroupInterface::class
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
        \Cybage\Storelocator\Api\Data\DealergroupInterface $dealergroup
    ) {
        try {
            $dealergroupModel = $this->dealergroupFactory->create();
            $this->resource->load($dealergroupModel, $dealergroup->getDealergroupId());
            $this->resource->delete($dealergroupModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Dealergroup: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($dealergroupId)
    {
        return $this->delete($this->getById($dealergroupId));
    }
}
