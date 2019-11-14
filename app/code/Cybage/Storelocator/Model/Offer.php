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

use Cybage\Storelocator\Api\Data\OfferInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Cybage\Storelocator\Api\Data\OfferInterface;

class Offer extends \Magento\Framework\Model\AbstractModel
{

    protected $offerDataFactory;
    protected $dataObjectHelper;
    protected $_eventPrefix = 'cybage_storelocator_offer';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param OfferInterfaceFactory $offerDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Cybage\Storelocator\Model\ResourceModel\Offer $resource
     * @param \Cybage\Storelocator\Model\ResourceModel\Offer\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        OfferInterfaceFactory $offerDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Cybage\Storelocator\Model\ResourceModel\Offer $resource,
        \Cybage\Storelocator\Model\ResourceModel\Offer\Collection $resourceCollection,
        array $data = []
    ) {
        $this->offerDataFactory = $offerDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve offer model with offer data
     * @return OfferInterface
     */
    public function getDataModel()
    {
        $offerData = $this->getData();

        $offerDataObject = $this->offerDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $offerDataObject,
            $offerData,
            OfferInterface::class
        );

        return $offerDataObject;
    }
}
