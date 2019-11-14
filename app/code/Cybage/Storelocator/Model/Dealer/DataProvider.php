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

namespace Cybage\Storelocator\Model\Dealer;

use Magento\Framework\App\Request\DataPersistorInterface;
use Cybage\Storelocator\Model\ResourceModel\Dealer\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $loadedData;
    protected $dataPersistor;
    protected $collection;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct($name, $primaryFieldName, $requestFieldName, CollectionFactory $collectionFactory, DataPersistorInterface $dataPersistor, \Cybage\Storelocator\Model\Dropdown\Group $group, \Cybage\Storelocator\Model\Dropdown\City $city, array $meta = [], array $data = [])
    {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->group = $group;
        $this->city = $city;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            if (isset($model)) {
                $data = $model->getData();
                if (isset($data['dealer_logo'])) {
                    unset($data['dealer_logo']);
                    $data['dealer_logo'][0]['name'] = $model->getData('dealer_logo');
                    $data['dealer_logo'][0]['url'] = $model->getImageUrl();
                }
            }
            $this->loadedData[$model->getId()] = $data;
        }

        $data = $this->dataPersistor->get('cybage_storelocator_dealer');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('cybage_storelocator_dealer');
        } else {
            if (!empty($this->loadedData)) {
                $this->loadedData[$model->getId()]['group_id'] = $this->group->getGroupName($model->getGroupId());
                $this->loadedData[$model->getId()]['city_id'] = $this->city->getCityName($model->getCityId());
                $this->loadedData[$model->getId()]['subcategories'] = explode(',', $model->getSubcategories());
            }
        }

        return $this->loadedData;
    }
}
