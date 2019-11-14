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

use Magento\Framework\Api\DataObjectHelper;
use Cybage\Storelocator\Api\Data\OffertypeInterface;
use Cybage\Storelocator\Api\Data\OffertypeInterfaceFactory;

class Offertype extends \Magento\Framework\Model\AbstractModel
{

    protected $offertypeDataFactory;
    protected $_eventPrefix = 'cybage_storelocator_offertype';
    protected $dataObjectHelper;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param OffertypeInterfaceFactory $offertypeDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Cybage\Storelocator\Model\ResourceModel\Offertype $resource
     * @param \Cybage\Storelocator\Model\ResourceModel\Offertype\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        OffertypeInterfaceFactory $offertypeDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Cybage\Storelocator\Model\ResourceModel\Offertype $resource,
        \Cybage\Storelocator\Model\ResourceModel\Offertype\Collection $resourceCollection,
        array $data = []
    ) {
        $this->offertypeDataFactory = $offertypeDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve offertype model with offertype data
     * @return OffertypeInterface
     */
    public function getDataModel()
    {
        $offertypeData = $this->getData();

        $offertypeDataObject = $this->offertypeDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $offertypeDataObject,
            $offertypeData,
            OffertypeInterface::class
        );

        return $offertypeDataObject;
    }
}
