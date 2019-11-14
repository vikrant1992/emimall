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



namespace Mirasvit\Sorting\Service;


use Magento\Catalog\Model\Config as CatalogConfig;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;
use Mirasvit\Sorting\Api\Data\CriterionInterface;
use Mirasvit\Sorting\Api\Repository\CriterionRepositoryInterface;
use Mirasvit\Sorting\Model\Config;

class CriteriaManagementService
{
    const DEFAULT_DIRECTION = 'asc';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var CatalogConfig
     */
    private $catalogConfig;

    /**
     * @var RequestInterface
     */
    private $request;

    private $registry;

    private $criterionRepository;

    public function __construct(
        CriterionRepositoryInterface $criterionRepository,
        RequestInterface $request,
        CatalogConfig $catalogConfig,
        Registry $registry,
        Config $config
    ) {
        $this->criterionRepository = $criterionRepository;
        $this->request             = $request;
        $this->catalogConfig       = $catalogConfig;
        $this->registry            = $registry;
        $this->config              = $config;
    }

    /**
     * @return false|CriterionInterface
     */
    public function getDefaultCriterion()
    {
        $collection = $this->criterionRepository->getCollection()
            ->addFieldToFilter(CriterionInterface::IS_ACTIVE, 1);

        if ($this->request->getModuleName() === 'catalogsearch'
            || $this->request->getModuleName() === 'searchautocomplete') {
            $collection->addFieldToFilter(CriterionInterface::IS_SEARCH_DEFAULT, 1);
        } else {
            $collection->addFieldToFilter(CriterionInterface::IS_DEFAULT, 1);
        }

        /** @var CriterionInterface $criterion */
        $criterion = $collection->getFirstItem();

        if ($this->registry->registry('current_category')) {
            /** @var \Magento\Catalog\Model\Category $category */
            $category = $this->registry->registry('current_category');

            //we have custom sort for catalog
            if ($category->getDefaultSortBy() !== $this->catalogConfig->getProductListDefaultSortBy()) {
                $customCriterion = $this->criterionRepository->getCollection()
                    ->addFieldToFilter(CriterionInterface::IS_ACTIVE, 1)
                    ->addFieldToFilter(CriterionInterface::CODE, $category->getDefaultSortBy())
                    ->getFirstItem();

                if ($customCriterion->getId()) {
                    $criterion = $customCriterion;
                }
            }
        }

        return $criterion->getId() ? $criterion : false;
    }

    public function getDefaultDirection(CriterionInterface $criterion)
    {
        foreach ($criterion->getConditionCluster()->getFrames() as $frame) {
            foreach ($frame->getNodes() as $node) {
                return $node->getDirection();
            }
        }

        return 'asc';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultCriteria()
    {
        $options = ['position' => __('Position')];

        foreach ($this->catalogConfig->getAttributesUsedForSortBy() as $attribute) {
            /* @var $attribute \Magento\Eav\Model\Entity\Attribute\AbstractAttribute */
            $options[$attribute->getAttributeCode()] = $attribute->getStoreLabel();
        }

        return $options;
    }
}
