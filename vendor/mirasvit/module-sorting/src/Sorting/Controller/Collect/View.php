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



namespace Mirasvit\Sorting\Controller\Collect;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Reports\Model\Product\Index\ViewedFactory;
use Magento\Store\Model\StoreManagerInterface;

class View extends Action
{
    private $storeManager;

    private $viewedFactory;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        ViewedFactory $viewedFactory
    ) {
        $this->storeManager  = $storeManager;
        $this->viewedFactory = $viewedFactory;

        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD)
     */
    public function execute()
    {
        $productId = $this->getRequest()->getParam('id');

        $viewData['product_id'] = $productId;
        $viewData['store_id']   = $this->storeManager->getStore()->getId();

        $this->viewedFactory->create()->setData($viewData)->save();

        /** @var \Magento\Framework\App\Response\Http $response */
        $response = $this->getResponse();
        $response->representJson(\Zend_Json_Encoder::encode([
            'success' => true,
        ]));
    }
}
