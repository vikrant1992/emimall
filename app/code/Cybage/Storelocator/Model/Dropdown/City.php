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

namespace Cybage\Storelocator\Model\Dropdown;

class City extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * Constructor
     * @param \Cybage\Storelocator\Model\CityFactory $cityFactory
     */
    public function __construct(
        \Cybage\Storelocator\Model\CityFactory $cityFactory
    ) {
        $this->cityFactory = $cityFactory;
    }

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        $cityCollection = $this->cityFactory->create()
                ->getCollection()
                ->addFieldToSelect('bajaj_city_id')
                ->addFieldToSelect('city_name')
                ->getData();

        foreach ($cityCollection as $groupData) {
            $this->_options[] = ['value' => $groupData['bajaj_city_id'], 'label' => __($groupData['city_name'])];
        }
        if (empty($this->_options)) {
            $this->_options[] = ['value' => '', 'label' => __('')];
        }
        return $this->_options;
    }

    /**
     * Get city name by id
     *
     * @return array
     */
    public function getCityName($id)
    {
        $dealerGroupCollection = $this->cityFactory->create()
                ->getCollection()
                ->addFieldToFilter('bajaj_city_id', ['eq' => $id])
                ->getFirstItem()
                ->getData();
        if (!empty($dealerGroupCollection)) {
            return $dealerGroupCollection['city_name'] . ' - ' . $dealerGroupCollection['bajaj_city_id'];
        }
        return '';
    }
}
