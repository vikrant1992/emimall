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

class Group extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * Constructor
     * @param \Cybage\Storelocator\Model\DealergroupFactory $groupFactory
     */
    public function __construct(
        \Cybage\Storelocator\Model\DealergroupFactory $groupFactory
    ) {
        $this->groupFactory = $groupFactory;
    }

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        $dealerGroupCollection = $this->groupFactory->create()
                ->getCollection()
                ->addFieldToSelect('group_id')
                ->addFieldToSelect('store_name')
                ->getData();

        foreach ($dealerGroupCollection as $groupData) {
            $this->_options[] = ['value' => $groupData['group_id'], 'label' => __($groupData['store_name'])];
        }
        if (empty($this->_options)) {
            $this->_options[] = ['value' => '', 'label' => __('')];
        }
        return $this->_options;
    }

    /**
     * Get group name by id
     *
     * @return array
     */
    public function getGroupName($id)
    {
        $dealerGroupCollection = $this->groupFactory->create()
                ->getCollection()
                ->addFieldToFilter('group_id', ['eq' => $id])
                ->getFirstItem()
                ->getData();
        if (!empty($dealerGroupCollection)) {
            return $dealerGroupCollection['store_name'] . ' - ' . $dealerGroupCollection['group_id'];
        }
        return '';
    }
}
