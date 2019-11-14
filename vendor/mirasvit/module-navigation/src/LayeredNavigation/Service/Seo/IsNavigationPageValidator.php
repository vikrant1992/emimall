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




namespace Mirasvit\LayeredNavigation\Service\Seo;


use Magento\Catalog\Model\Layer\Resolver as LayerResolver;
use Magento\Framework\App\RequestInterface;
use Mirasvit\SeoNavigation\Service\ValidatorInterface;

class IsNavigationPageValidator implements ValidatorInterface
{
    /**
     * @var LayerResolver
     */
    private $layerResolver;

    public function __construct(LayerResolver $layerResolver)
    {
        $this->layerResolver = $layerResolver;
    }

    /**
     * @inheritdoc
     */
    public function isApplicable(RequestInterface $request)
    {
        if ($this->layerResolver->get()->getState()->getFilters()) {
            return true;
        }

        return false;
    }
}
