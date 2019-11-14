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

use Magento\Framework\Api\DataObjectHelper;
use Cybage\Storelocator\Api\Data\DealergroupInterface;
use Cybage\Storelocator\Api\Data\DealergroupInterfaceFactory;

class Dealergroup extends \Magento\Framework\Model\AbstractModel
{

    protected $_eventPrefix = 'cybage_storelocator_dealergroup';
    protected $dataObjectHelper;
    protected $dealergroupDataFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param DealergroupInterfaceFactory $dealergroupDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Cybage\Storelocator\Model\ResourceModel\Dealergroup $resource
     * @param \Cybage\Storelocator\Model\ResourceModel\Dealergroup\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        DealergroupInterfaceFactory $dealergroupDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Cybage\Storelocator\Model\ResourceModel\Dealergroup $resource,
        \Cybage\Storelocator\Model\ResourceModel\Dealergroup\Collection $resourceCollection,
        array $data = []
    ) {
        $this->dealergroupDataFactory = $dealergroupDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve dealergroup model with dealergroup data
     * @return DealergroupInterface
     */
    public function getDataModel()
    {
        $dealergroupData = $this->getData();

        $dealergroupDataObject = $this->dealergroupDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $dealergroupDataObject,
            $dealergroupData,
            DealergroupInterface::class
        );

        return $dealergroupDataObject;
    }
}
