<?php

/**
 * BFL Cybage_Storelocator
 *
 * @category   Cybage_Storelocator
 * @package    BFL Cybage_Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Model;

use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\DataObjectHelper;
use Cybage\Storelocator\Model\ResourceModel\Offertype\CollectionFactory as OffertypeCollectionFactory;
use Cybage\Storelocator\Api\OffertypeRepositoryInterface;
use Cybage\Storelocator\Model\ResourceModel\Offertype as ResourceOffertype;
use Magento\Framework\Exception\CouldNotDeleteException;
use Cybage\Storelocator\Api\Data\OffertypeInterfaceFactory;
use Magento\Store\Model\StoreManagerInterface;
use Cybage\Storelocator\Api\Data\OffertypeSearchResultsInterfaceFactory;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Reflection\DataObjectProcessor;

class OffertypeRepository implements OffertypeRepositoryInterface
{

    protected $resource;
    protected $extensionAttributesJoinProcessor;
    protected $extensibleDataObjectConverter;
    protected $dataOffertypeFactory;
    protected $offertypeFactory;
    protected $dataObjectProcessor;
    private $storeManager;
    private $collectionProcessor;
    protected $dataObjectHelper;
    protected $offertypeCollectionFactory;
    protected $searchResultsFactory;

    /**
     * @param ResourceOffertype $resource
     * @param OffertypeFactory $offertypeFactory
     * @param OffertypeInterfaceFactory $dataOffertypeFactory
     * @param OffertypeCollectionFactory $offertypeCollectionFactory
     * @param OffertypeSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceOffertype $resource,
        OffertypeFactory $offertypeFactory,
        OffertypeInterfaceFactory $dataOffertypeFactory,
        OffertypeCollectionFactory $offertypeCollectionFactory,
        OffertypeSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->offertypeFactory = $offertypeFactory;
        $this->offertypeCollectionFactory = $offertypeCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataOffertypeFactory = $dataOffertypeFactory;
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
        \Cybage\Storelocator\Api\Data\OffertypeInterface $offertype
    ) {
        /* if (empty($offertype->getStoreId())) {
          $storeId = $this->storeManager->getStore()->getId();
          $offertype->setStoreId($storeId);
          } */

        $offertypeData = $this->extensibleDataObjectConverter->toNestedArray(
            $offertype,
            [],
            \Cybage\Storelocator\Api\Data\OffertypeInterface::class
        );

        $offertypeModel = $this->offertypeFactory->create()->setData($offertypeData);

        try {
            $this->resource->save($offertypeModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the offertype: %1',
                $exception->getMessage()
            ));
        }
        return $offertypeModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($offertypeId)
    {
        $offertype = $this->offertypeFactory->create();
        $this->resource->load($offertype, $offertypeId);
        if (!$offertype->getId()) {
            throw new NoSuchEntityException(__('Offertype with id "%1" does not exist.', $offertypeId));
        }
        return $offertype->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->offertypeCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Cybage\Storelocator\Api\Data\OffertypeInterface::class
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
        \Cybage\Storelocator\Api\Data\OffertypeInterface $offertype
    ) {
        try {
            $offertypeModel = $this->offertypeFactory->create();
            $this->resource->load($offertypeModel, $offertype->getOffertypeId());
            $this->resource->delete($offertypeModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Offertype: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($offertypeId)
    {
        return $this->delete($this->getById($offertypeId));
    }
}
