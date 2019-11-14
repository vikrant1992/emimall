<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-navigation
 * @version   1.0.77
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\LayeredNavigation\Repository;

use Magento\Framework\EntityManager\EntityManager;
use Mirasvit\LayeredNavigation\Api\Data\AttributeConfigInterface;
use Mirasvit\LayeredNavigation\Api\Data\AttributeConfigInterfaceFactory;
use Mirasvit\LayeredNavigation\Model\ResourceModel\AttributeConfig\CollectionFactory;

class AttributeConfigRepository
{
    /**
     * @var AttributeConfigInterfaceFactory
     */
    private $factory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        AttributeConfigInterfaceFactory $factory,
        CollectionFactory $collectionFactory,
        EntityManager $entityManager
    ) {
        $this->factory           = $factory;
        $this->collectionFactory = $collectionFactory;
        $this->entityManager     = $entityManager;
    }

    public function create()
    {
        return $this->factory->create();
    }

    public function getCollection()
    {
        return $this->collectionFactory->create();
    }

    public function get($id)
    {
        $model = $this->create();

        $this->entityManager->load($model, $id);

        return $model->getId() ? $model : false;
    }

    public function getByAttributeCode($code)
    {
        /** @var AttributeConfigInterface $model */
        $model = $this->getCollection()
            ->addFieldToFilter(AttributeConfigInterface::ATTRIBUTE_CODE, $code)
            ->getFirstItem();

        return $model->getId() ? $model : false;
    }

    public function save(AttributeConfigInterface $model)
    {
        return $this->entityManager->save($model);
    }

    public function delete(AttributeConfigInterface $model)
    {
        return $this->entityManager->delete($model);
    }
}