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

use Cybage\Storelocator\Api\Data\DealerInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Cybage\Storelocator\Api\Data\DealerInterface;

class Dealer extends \Magento\Framework\Model\AbstractModel
{

    protected $dealerDataFactory;
    protected $_eventPrefix = 'cybage_storelocator_dealer';
    protected $dataObjectHelper;
    
    /**
     *
     * @var \Cybage\Storelocator\Model\ImageUploaderPool
     */
    protected $imageUploaderPool;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param DealerInterfaceFactory $dealerDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Cybage\Storelocator\Model\ResourceModel\Dealer $resource
     * @param \Cybage\Storelocator\Model\ResourceModel\Dealer\Collection $resourceCollection
     * @param \Cybage\Storelocator\Model\ImageUploaderPool $imageUploaderPool
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        DealerInterfaceFactory $dealerDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Cybage\Storelocator\Model\ResourceModel\Dealer $resource,
        \Cybage\Storelocator\Model\ResourceModel\Dealer\Collection $resourceCollection,
        \Cybage\Storelocator\Model\ImageUploaderPool $imageUploaderPool,
        array $data = []
    ) {
        $this->dealerDataFactory = $dealerDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->imageUploaderPool = $imageUploaderPool;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve dealer model with dealer data
     * @return DealerInterface
     */
    public function getDataModel()
    {
        $dealerData = $this->getData();

        $dealerDataObject = $this->dealerDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $dealerDataObject,
            $dealerData,
            DealerInterface::class
        );

        return $dealerDataObject;
    }
    
    /**
     * Get image URL
     *
     * @return bool|string
     * @throws LocalizedException
     */
    public function getImageUrl()
    {
        $url = false;
        $image = $this->getData('dealer_logo');
        if ($image) {
            if (is_string($image)) {
                $uploader = $this->imageUploaderPool->getUploader('image');
                $url = $uploader->getBaseUrl() . $uploader->getBasePath() . $image;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
}
