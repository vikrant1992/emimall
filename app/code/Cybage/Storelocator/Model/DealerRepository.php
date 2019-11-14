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

use Cybage\Storelocator\Api\DealerRepositoryInterface;
use Cybage\Storelocator\Api\Data\DealerSearchResultsInterfaceFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\DataObjectHelper;
use Cybage\Storelocator\Model\ResourceModel\Dealer\CollectionFactory as DealerCollectionFactory;
use Cybage\Storelocator\Api\Data\DealerInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Cybage\Storelocator\Model\ResourceModel\Dealer as ResourceDealer;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Reflection\DataObjectProcessor;

class DealerRepository implements DealerRepositoryInterface
{

    protected $resource;
    protected $extensionAttributesJoinProcessor;
    protected $dealerCollectionFactory;
    protected $extensibleDataObjectConverter;
    protected $dataObjectProcessor;
    private $storeManager;
    private $collectionProcessor;
    protected $dataObjectHelper;
    protected $dealerFactory;
    protected $dataDealerFactory;
    protected $searchResultsFactory;

    /**
     * @param ResourceDealer $resource
     * @param DealerFactory $dealerFactory
     * @param DealerInterfaceFactory $dataDealerFactory
     * @param DealerCollectionFactory $dealerCollectionFactory
     * @param DealerSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceDealer $resource,
        DealerFactory $dealerFactory,
        DealerInterfaceFactory $dataDealerFactory,
        DealerCollectionFactory $dealerCollectionFactory,
        DealerSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->dealerFactory = $dealerFactory;
        $this->dealerCollectionFactory = $dealerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataDealerFactory = $dataDealerFactory;
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
        \Cybage\Storelocator\Api\Data\DealerInterface $dealer
    ) {
        /* if (empty($dealer->getStoreId())) {
          $storeId = $this->storeManager->getStore()->getId();
          $dealer->setStoreId($storeId);
          } */

        $dealerData = $this->extensibleDataObjectConverter->toNestedArray(
            $dealer,
            [],
            \Cybage\Storelocator\Api\Data\DealerInterface::class
        );

        $dealerModel = $this->dealerFactory->create()->setData($dealerData);

        try {
            $this->resource->save($dealerModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the dealer: %1',
                $exception->getMessage()
            ));
        }
        return $dealerModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($dealerId)
    {
        $dealer = $this->dealerFactory->create();
        $this->resource->load($dealer, $dealerId);
        if (!$dealer->getId()) {
            throw new NoSuchEntityException(__('Dealer with id "%1" does not exist.', $dealerId));
        }
        return $dealer->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->dealerCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Cybage\Storelocator\Api\Data\DealerInterface::class
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
        \Cybage\Storelocator\Api\Data\DealerInterface $dealer
    ) {
        try {
            $dealerModel = $this->dealerFactory->create();
            $this->resource->load($dealerModel, $dealer->getDealerId());
            $this->resource->delete($dealerModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Dealer: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($dealerId)
    {
        return $this->delete($this->getById($dealerId));
    }
}
