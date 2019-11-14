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
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Api\Data\RankingFactorInterfaceFactory;
use Mirasvit\Sorting\Api\Repository\RankingFactorRepositoryInterface;
use Mirasvit\Sorting\Factor\FactorInterface;
use Mirasvit\Sorting\Model\ResourceModel\RankingFactor\CollectionFactory;

class RankingFactorRepository implements RankingFactorRepositoryInterface
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
        RankingFactorInterfaceFactory $factory,
        CollectionFactory $collectionFactory,
        array $pool = []
    ) {
        $this->entityManager     = $entityManager;
        $this->factory           = $factory;
        $this->collectionFactory = $collectionFactory;
        $this->pool              = $pool;
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
    public function getFactors()
    {
        return $this->pool;
    }

    /**
     * {@inheritdoc}
     */
    public function getFactor($type)
    {
        foreach ($this->getFactors() as $identifier => $factor) {
            if ($identifier == $type) {
                return $factor;
            }
        }

        return false;
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
    public function save(RankingFactorInterface $model)
    {
        $this->entityManager->save($model);

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(RankingFactorInterface $model)
    {
        $this->entityManager->delete($model);

        return $this;
    }
}
