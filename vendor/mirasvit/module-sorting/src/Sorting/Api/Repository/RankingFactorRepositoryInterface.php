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



namespace Mirasvit\Sorting\Api\Repository;

use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Factor\FactorInterface;

interface RankingFactorRepositoryInterface
{
    /**
     * @return \Mirasvit\Sorting\Model\ResourceModel\RankingFactor\Collection | RankingFactorInterface[]
     */
    public function getCollection();

    /**
     * @return FactorInterface[]
     */
    public function getFactors();

    /**
     * @param string $type
     *
     * @return FactorInterface
     */
    public function getFactor($type);

    /**
     * @return RankingFactorInterface
     */
    public function create();

    /**
     * @param int $id
     *
     * @return RankingFactorInterface
     */
    public function get($id);

    /**
     * @param RankingFactorInterface $model
     *
     * @return $this
     */
    public function save(RankingFactorInterface $model);

    /**
     * @param RankingFactorInterface $model
     *
     * @return $this
     */
    public function delete(RankingFactorInterface $model);
}