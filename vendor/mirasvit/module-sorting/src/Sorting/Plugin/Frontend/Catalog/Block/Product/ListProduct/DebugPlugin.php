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



namespace Mirasvit\Sorting\Plugin\Frontend\Catalog\Block\Product\ListProduct;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\LayoutInterface;
use Mirasvit\Sorting\Api\Data\IndexInterface;
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Block\Debug;
use Mirasvit\Sorting\Model\Config;
use Mirasvit\Sorting\Repository\RankingFactorRepository;

class DebugPlugin
{
    private $config;

    private $rankingFactorRepository;

    private $resource;

    private $layout;

    static  $factorName = [];

    public function __construct(
        Config $config,
        RankingFactorRepository $rankingFactorRepository,
        ResourceConnection $resource,
        LayoutInterface $layout
    ) {
        $this->config                  = $config;
        $this->rankingFactorRepository = $rankingFactorRepository;
        $this->resource                = $resource;
        $this->layout                  = $layout;
    }

    public function afterGetProductDetailsHtml($subject, $html, $product = null)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        if (!$product) {
            return $html;
        }

        if (!$this->config->isDebug()) {
            return $html;
        }

        $globalScore    = $product->getData('sorting_score_global');
        $criterionScore = $product->getData('sorting_score_criterion');

        $select = $this->resource->getConnection()->select()
            ->from(
                $this->resource->getTableName(IndexInterface::TABLE_NAME),
                [IndexInterface::FACTOR_ID, IndexInterface::VALUE]
            )->where('product_id = ?', intval($product->getId()))
            ->order(IndexInterface::FACTOR_ID);

        $pairs = $this->resource->getConnection()->fetchPairs($select);

        $data = [];
        foreach ($pairs as $factorId => $value) {
            $name = $this->getFactorName($factorId);

            if (!$name) {
                continue;
            }

            $data[$name] = $value;
        }

        return $this->layout->createBlock(Debug::class, '', [
                'values'         => $data,
                'globalScore'    => $globalScore,
                'criterionScore' => $criterionScore,
            ])->toHtml() . $html;
    }

    /**
     * @param int $factorId
     *
     * @return bool|string
     */
    private function getFactorName($factorId)
    {
        if (count(self::$factorName) === 0) {
            $collection = $this->rankingFactorRepository->getCollection();
            $collection->addFieldToFilter(RankingFactorInterface::IS_ACTIVE, 1);

            /** @var \Mirasvit\Sorting\Model\RankingFactor $factor */
            foreach ($collection as $factor) {
                self::$factorName[$factor->getId()] = $factor->getName();
            }
        }

        return isset(self::$factorName[$factorId]) ? self::$factorName[$factorId] : false;
    }

}