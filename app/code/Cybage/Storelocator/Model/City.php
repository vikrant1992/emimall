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

use Cybage\Storelocator\Api\Data\CityInterface;
use Cybage\Storelocator\Api\Data\CityInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class City extends \Magento\Framework\Model\AbstractModel
{

    protected $cityDataFactory;
    protected $dataObjectHelper;
    protected $_eventPrefix = 'cybage_storelocator_city';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param CityInterfaceFactory $cityDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Cybage\Storelocator\Model\ResourceModel\City $resource
     * @param \Cybage\Storelocator\Model\ResourceModel\City\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        CityInterfaceFactory $cityDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Cybage\Storelocator\Model\ResourceModel\City $resource,
        \Cybage\Storelocator\Model\ResourceModel\City\Collection $resourceCollection,
        array $data = []
    ) {
        $this->cityDataFactory = $cityDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve city model with city data
     * @return CityInterface
     */
    public function getDataModel()
    {
        $cityData = $this->getData();

        $cityDataObject = $this->cityDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $cityDataObject,
            $cityData,
            CityInterface::class
        );

        return $cityDataObject;
    }
}
