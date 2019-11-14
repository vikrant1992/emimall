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



namespace Mirasvit\Brand\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mirasvit\Brand\Api\Data\BrandInterface;
use Mirasvit\Brand\Api\Repository\BrandRepositoryInterface;
use Mirasvit\Brand\Api\Service\BrandAttributeServiceInterface;
use Mirasvit\Brand\Model\Config\Config;

class BrandList extends Template
{
    private $brandRepository;

    private $brandAttributeService;

    private $config;

    public function __construct(
        BrandRepositoryInterface $brandRepository,
        BrandAttributeServiceInterface $brandAttributeService,
        Config $config,
        Context $context
    ) {
        $this->brandRepository       = $brandRepository;
        $this->brandAttributeService = $brandAttributeService;
        $this->config                = $config;

        parent::__construct($context);
    }

    /**
     * Return collection of brands grouped by first letter.
     * @return array
     */
    public function getBrandsByLetters()
    {
        $collectionByLetters = [];
        $collection          = $this->brandRepository->getCollection();

        foreach ($collection as $brand) {
            $letter = strtoupper(mb_substr(trim($brand->getLabel()), 0, 1));

            if (isset($collectionByLetters[$letter])) {
                $collectionByLetters[$letter][$brand->getLabel()] = $brand;
            } else {
                $collectionByLetters[$letter] = [$brand->getLabel() => $brand];
            }
        }

        // sort brands alphabetically
        ksort($collectionByLetters);
        foreach ($collectionByLetters as $letter => $brands) {
            ksort($brands);
            $collectionByLetters[$letter] = $brands;
        }

        return $collectionByLetters;
    }

    /**
     * @param BrandInterface $brand
     *
     * @return bool
     */
    public function canShowImage(BrandInterface $brand)
    {
        return $this->config->getAllBrandPageConfig()->isShowBrandLogo() && $brand->getImage();
    }
}
