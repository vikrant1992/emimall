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

use Mirasvit\Sorting\Api\Data\CriterionInterface;

interface CriterionRepositoryInterface
{
    /**
     * @return \Mirasvit\Sorting\Model\ResourceModel\Criterion\Collection | CriterionInterface[]
     */
    public function getCollection();

    /**
     * @return CriterionInterface
     */
    public function create();

    /**
     * @param int $id
     *
     * @return CriterionInterface|false
     */
    public function get($id);

    /**
     * @param string $code
     *
     * @return CriterionInterface|false
     */
    public function getByCode($code);

    /**
     * @param CriterionInterface $model
     *
     * @return $this
     */
    public function save(CriterionInterface $model);

    /**
     * @param CriterionInterface $model
     *
     * @return $this
     */
    public function delete(CriterionInterface $model);
}
