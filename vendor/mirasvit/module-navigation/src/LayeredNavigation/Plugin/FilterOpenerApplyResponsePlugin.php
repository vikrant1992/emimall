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



namespace Mirasvit\LayeredNavigation\Plugin;

use Magento\Framework\App\ResponseInterface;
use Mirasvit\LayeredNavigation\Observer\FilterOpener;

class FilterOpenerApplyResponsePlugin
{
    public function __construct(
        FilterOpener $filterOpener
    ) {
        $this->filterOpener = $filterOpener;
    }


    /**
     * Modify and cache application response
     *
     * @param \Magento\Framework\App\PageCache\Kernel $subject
     * @param ResponseInterface $response
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeProcess($subject, ResponseInterface $response)
    {
        $response = $this->filterOpener->filterOpen(false, $response);
    }
}
