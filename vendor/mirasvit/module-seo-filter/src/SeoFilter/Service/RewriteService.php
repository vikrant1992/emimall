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
 * @package   mirasvit/module-seo-filter
 * @version   1.0.14
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\SeoFilter\Service;

use Magento\Catalog\Model\Layer\Resolver as LayerResolver;
use Mirasvit\SeoFilter\Api\Data\RewriteInterface;
use Mirasvit\SeoFilter\Api\Repository\RewriteRepositoryInterface;
use Mirasvit\SeoFilter\Model\Config;
use Mirasvit\SeoFilter\Model\Context;

class RewriteService
{
    /**
     * @var array
     */
    private static $activeFilters = null;

    private        $rewriteRepository;

    private        $layerResolver;

    private        $context;

    private        $labelService;

    public function __construct(
        RewriteRepositoryInterface $rewriteRepository,
        LayerResolver $layerResolver,
        Context $context,
        LabelService $labelService
    ) {
        $this->rewriteRepository = $rewriteRepository;
        $this->layerResolver     = $layerResolver;
        $this->context           = $context;
        $this->labelService      = $labelService;
    }

    /**
     * {@inheritdoc}
     */
    public function getRewrite($attributeCode, $filterValue)
    {
        if ($attributeCode == Config::FILTER_RATING) {
            return $this->getRatingFilterRewrite($filterValue);
        } elseif ($attributeCode == Config::FILTER_STOCK) {
            return $this->getStockFilterRewrite($filterValue);
        } elseif ($attributeCode == Config::FILTER_SALE) {
            return $this->getSaleFilterRewrite();
        } elseif ($attributeCode == Config::FILTER_NEW) {
            return $this->getNewFilterRewrite();
        }

        /** @var RewriteInterface $rewrite */
        $rewrite = $this->rewriteRepository->getCollection()
            ->addFieldToFilter(RewriteInterface::ATTRIBUTE_CODE, $attributeCode)
            ->addFieldToFilter(RewriteInterface::OPTION, $filterValue)
            ->addFieldToFilter(RewriteInterface::STORE_ID, $this->context->getStoreId())
            ->getFirstItem();

        if ($rewrite->getId()) {
            return $rewrite->getRewrite();
        }

        $rewrite = $this->createNewRewrite($attributeCode, $filterValue);

        return $rewrite ? $rewrite->getRewrite() : false;
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveFilters()
    {
        if (self::$activeFilters === null) {
            self::$activeFilters = [];

            $layer = $this->layerResolver->get();

            foreach ($layer->getState()->getFilters() as $item) {
                $filter      = $item->getFilter();
                $filterValue = $item->getData('value');

                if ($filter->getData('attribute_model')) {
                    $attributeCode = $filter->getAttributeModel()->getAttributeCode();
                } else {
                    $attributeCode = $filter->getRequestVar();
                }

                foreach (explode(Config::SEPARATOR_FILTER_VALUES, $filterValue) as $value) {
                    self::$activeFilters[$attributeCode][$value] = $value;
                }
            }
        }

        return self::$activeFilters;
    }

    private function getStockFilterRewrite($stockValue)
    {
        return $stockValue === 1 || $stockValue === '1' ? Config::LABEL_STOCK_IN : Config::LABEL_STOCK_OUT;
    }

    private function getSaleFilterRewrite()
    {
        return Config::FILTER_SALE;
    }

    private function getNewFilterRewrite()
    {
        return Config::FILTER_NEW;
    }

    private function getRatingFilterRewrite($ratingValue)
    {
        switch ($ratingValue) {
            case 1:
                $rewrite = Config::LABEL_RATING_1;
                break;
            case 2:
                $rewrite = Config::LABEL_RATING_2;
                break;
            case 3:
                $rewrite = Config::LABEL_RATING_3;
                break;
            case 4:
                $rewrite = Config::LABEL_RATING_4;
                break;
            case 5:
                $rewrite = Config::LABEL_RATING_5;
                break;
            default:
                $rewrite = Config::LABEL_RATING_5;
        }

        return $rewrite;
    }

    /**
     * @param string $attributeCode
     * @param string $filterValue
     *
     * @return false|RewriteInterface
     */
    private function createNewRewrite($attributeCode, $filterValue)
    {
        $attribute = $this->context->getAttribute($attributeCode);
        if (!$attribute) {
            return false;
        }

        $attributeId = $attribute->getId();

        $attributeOption = $this->context->getAttributeOption($attributeId, $filterValue);

        if ($this->context->isDecimalAttribute($attributeCode)) {
            $label = $this->labelService->createLabel($attributeCode, $filterValue);
        } elseif ($attributeOption) {
            $label = $this->labelService->createLabel($attributeCode, $attributeOption->getValue());
        } elseif ($filterValue === 1 || $filterValue === '1') {
            $label = $attributeCode;
        } elseif ($filterValue === 0 || $filterValue === '0') {
            $label = $attributeCode . '_no';
        } else {
            return false;
        }

        $label = $this->labelService->uniqueLabel($label);

        $rewrite = $this->rewriteRepository->create();
        $rewrite->setAttributeCode($attributeCode)
            ->setOption($filterValue)
            ->setRewrite($label)
            ->setStoreId($this->context->getStoreId());

        $this->rewriteRepository->save($rewrite);

        return $rewrite;
    }
}