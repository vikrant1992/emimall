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

use Cybage\Storelocator\Model\ResourceModel\Offer as ResourceOffer;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\DataObjectHelper;
use Cybage\Storelocator\Api\Data\OfferSearchResultsInterfaceFactory;
use Cybage\Storelocator\Api\OfferRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Store\Model\StoreManagerInterface;
use Cybage\Storelocator\Api\Data\OfferInterfaceFactory;
use Cybage\Storelocator\Model\ResourceModel\Offer\CollectionFactory as OfferCollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\ExtensibleDataObjectConverter;

class OfferRepository implements OfferRepositoryInterface
{

    protected $resource;
    protected $extensionAttributesJoinProcessor;
    protected $extensibleDataObjectConverter;
    protected $offerFactory;
    protected $offerCollectionFactory;
    protected $dataOfferFactory;
    protected $dataObjectProcessor;
    private $storeManager;
    private $collectionProcessor;
    protected $dataObjectHelper;
    protected $searchResultsFactory;

    /**
     * @param ResourceOffer $resource
     * @param OfferFactory $offerFactory
     * @param OfferInterfaceFactory $dataOfferFactory
     * @param OfferCollectionFactory $offerCollectionFactory
     * @param OfferSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceOffer $resource,
        OfferFactory $offerFactory,
        OfferInterfaceFactory $dataOfferFactory,
        OfferCollectionFactory $offerCollectionFactory,
        OfferSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->offerFactory = $offerFactory;
        $this->offerCollectionFactory = $offerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataOfferFactory = $dataOfferFactory;
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
        \Cybage\Storelocator\Api\Data\OfferInterface $offer
    ) {
        /* if (empty($offer->getStoreId())) {
          $storeId = $this->storeManager->getStore()->getId();
          $offer->setStoreId($storeId);
          } */

        $offerData = $this->extensibleDataObjectConverter->toNestedArray(
            $offer,
            [],
            \Cybage\Storelocator\Api\Data\OfferInterface::class
        );

        $offerModel = $this->offerFactory->create()->setData($offerData);

        try {
            $this->resource->save($offerModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the offer: %1',
                $exception->getMessage()
            ));
        }
        return $offerModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($offerId)
    {
        $offer = $this->offerFactory->create();
        $this->resource->load($offer, $offerId);
        if (!$offer->getId()) {
            throw new NoSuchEntityException(__('Offer with id "%1" does not exist.', $offerId));
        }
        return $offer->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->offerCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Cybage\Storelocator\Api\Data\OfferInterface::class
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
        \Cybage\Storelocator\Api\Data\OfferInterface $offer
    ) {
        try {
            $offerModel = $this->offerFactory->create();
            $this->resource->load($offerModel, $offer->getOfferId());
            $this->resource->delete($offerModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Offer: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($offerId)
    {
        return $this->delete($this->getById($offerId));
    }
}
