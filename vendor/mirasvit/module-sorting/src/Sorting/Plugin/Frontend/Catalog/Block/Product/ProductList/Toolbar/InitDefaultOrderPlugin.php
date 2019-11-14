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



namespace Mirasvit\Sorting\Plugin\Frontend\Catalog\Block\Product\ProductList\Toolbar;

use Magento\Catalog\Block\Product\ProductList\Toolbar;
use Magento\Framework\App\RequestInterface;
use Mirasvit\Sorting\Api\Repository\CriterionRepositoryInterface;
use Mirasvit\Sorting\Service\CriteriaManagementService;

class InitDefaultOrderPlugin
{
    /**
     * @var CriteriaManagementService
     */
    private $criteriaManagement;

    /**
     * @var CriterionRepositoryInterface
     */
    private $criterionRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        CriterionRepositoryInterface $criterionRepository,
        CriteriaManagementService $criteriaManagement,
        RequestInterface $request
    ) {
        $this->criteriaManagement  = $criteriaManagement;
        $this->criterionRepository = $criterionRepository;
        $this->request             = $request;
    }

    /**
     * Initialize default sort order and direction.
     *
     * @param Toolbar                            $subject
     * @param \Magento\Framework\Data\Collection $collection
     */
    public function beforeSetCollection(Toolbar $subject, $collection)
    {
        $criterion = false;

        // 1. load criterion from order set as a GET parameter
        if ($this->request->getParam('product_list_order')) {
            $criterion = $this->criterionRepository->getByCode($this->request->getParam('product_list_order'));
        }

        // 2. if not exists - load default criterion otherwise
        if (!$criterion) {
            $criterion = $this->criteriaManagement->getDefaultCriterion();
        }

        if ($criterion) {
            $subject->setDefaultOrder($criterion->getCode());

            $subject->setDefaultDirection($this->criteriaManagement->getDefaultDirection($criterion));
        }
    }
}
