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



namespace Mirasvit\LayeredNavigation\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mirasvit\LayeredNavigation\Service\CssService;

class CssGenerate implements ObserverInterface
{
    private $cssService;

    public function __construct(
        CssService $cssService
    ) {
        $this->cssService = $cssService;
    }

    /**
     * @return void
     */
    public function execute(Observer $observer)
    {
        $this->cssService->generateCss($observer->getData('website'), $observer->getData('store'));
    }
}
