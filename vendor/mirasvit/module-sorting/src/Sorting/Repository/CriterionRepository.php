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
 * @package   mirasvit/module-sorting
 * @version   1.0.25
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\Sorting\Repository;

use Magento\Framework\EntityManager\EntityManager;
use Mirasvit\Sorting\Api\Data\CriterionInterface;
use Mirasvit\Sorting\Api\Data\CriterionInterfaceFactory;
use Mirasvit\Sorting\Api\Repository\CriterionRepositoryInterface;
use Mirasvit\Sorting\Factor\FactorInterface;
use Mirasvit\Sorting\Model\ResourceModel\Criterion\CollectionFactory;

class CriterionRepository implements CriterionRepositoryInterface
{
    private $entityManager;

    private $factory;

    private $collectionFactory;

    /**
     * @var FactorInterface[]
     */
    private $pool;

    public function __construct(
        EntityManager $entityManager,
        CriterionInterfaceFactory $factory,
        CollectionFactory $collectionFactory
    ) {
        $this->entityManager     = $entityManager;
        $this->factory           = $factory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection()
    {
        return $this->collectionFactory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return $this->factory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        $model = $this->create();

        $this->entityManager->load($model, $id);

        return $model->getId() ? $model : false;
    }

    /**
     * {@inheritdoc}
     */
    public function getByCode($code)
    {
        $model = $this->create();

        $model = $model->load($code, CriterionInterface::CODE);

        return $model->getId() ? $model : false;
    }

    /**
     * {@inheritdoc}
     */
    public function save(CriterionInterface $model)
    {
        if (!$model->getCode()) {
            $code = preg_replace("/[^a-z0-9]/i", '-', $model->getName());

            $model->setCode(strtolower($code));
        }

        $this->entityManager->save($model);


        $collection = $this->getCollection();
        $collection->addFieldToFilter(CriterionInterface::CODE, $model->getCode())
            ->addFieldToFilter(CriterionInterface::ID, ['neq' => $model->getId()]);

        if ($collection->getSize()) {
            $model->setCode($model->getCode() . '-1');
            $this->entityManager->save($model);
        }

        if ($model->isDefault()) {
            $collection = $this->getCollection();
            $collection->addFieldToFilter(CriterionInterface::IS_DEFAULT, 1)
                ->addFieldToFilter(CriterionInterface::ID, ['neq' => $model->getId()]);

            foreach ($collection as $item) {
                $item->setIsDefault(0);
                $this->save($item);
            }
        }

        if ($model->isSearchDefault()) {
            $collection = $this->getCollection();
            $collection->addFieldToFilter(CriterionInterface::IS_SEARCH_DEFAULT, 1)
                ->addFieldToFilter(CriterionInterface::ID, ['neq' => $model->getId()]);

            foreach ($collection as $item) {
                $item->setIsSearchDefault(0);
                $this->save($item);
            }
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(CriterionInterface $model)
    {
        $this->entityManager->delete($model);

        return $this;
    }
}
