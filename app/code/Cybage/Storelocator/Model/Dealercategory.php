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

use Cybage\Storelocator\Api\Data\DealercategoryInterfaceFactory;
use Cybage\Storelocator\Api\Data\DealercategoryInterface;
use Magento\Framework\Api\DataObjectHelper;

class Dealercategory extends \Magento\Framework\Model\AbstractModel
{

    protected $_eventPrefix = 'cybage_storelocator_dealercategory';
    protected $dataObjectHelper;
    protected $dealercategoryDataFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param DealercategoryInterfaceFactory $dealercategoryDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Cybage\Storelocator\Model\ResourceModel\Dealercategory $resource
     * @param \Cybage\Storelocator\Model\ResourceModel\Dealercategory\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        DealercategoryInterfaceFactory $dealercategoryDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Cybage\Storelocator\Model\ResourceModel\Dealercategory $resource,
        \Cybage\Storelocator\Model\ResourceModel\Dealercategory\Collection $resourceCollection,
        array $data = []
    ) {
        $this->dealercategoryDataFactory = $dealercategoryDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve dealercategory model with dealercategory data
     * @return DealercategoryInterface
     */
    public function getDataModel()
    {
        $dealercategoryData = $this->getData();

        $dealercategoryDataObject = $this->dealercategoryDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $dealercategoryDataObject,
            $dealercategoryData,
            DealercategoryInterface::class
        );

        return $dealercategoryDataObject;
    }
}
