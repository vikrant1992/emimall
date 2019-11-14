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



namespace Mirasvit\Brand\Service;

use Magento\Framework\Registry;
use Mirasvit\Brand\Api\Data\BrandPageInterface;
use Mirasvit\Brand\Api\Repository\BrandPageRepositoryInterface;
use Mirasvit\Brand\Api\Service\BrandPageServiceInterface;
use Mirasvit\Brand\Model\Config\BrandPageConfig;

class BrandPageService implements BrandPageServiceInterface
{
    /**
     * @var null|bool|BrandPageInterface
     */
    private static $brandPage = null;

    public function __construct(
        Registry $registry,
        BrandPageRepositoryInterface $brandPageRepository
    ) {
        $this->registry            = $registry;
        $this->brandPageRepository = $brandPageRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getBrandPage()
    {
        if (self::$brandPage !== null) {
            return self::$brandPage;
        }

        if (($brandData = $this->registry->registry(BrandPageConfig::BRAND_DATA))
            && ($brandPageId = $brandData[BrandPageConfig::BRAND_PAGE_ID])) {
            self::$brandPage = $this->brandPageRepository->get($brandPageId);
        } else {
            self::$brandPage = false;
        }

        return self::$brandPage;
    }
}